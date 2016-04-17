<?php namespace App\Http\Controllers;

use NZS\Core\CollectionAggregator;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;

use Illuminate\Http\Request;

class WampiriadaBackendController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
        $edition_number = (int) Option::get('wampiriada.edition', 26);
    
        return redirect('admin/wampiriada/show/' . $edition_number);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow($number) {
        $actions = Action::where('number', $number)->orderBy('day')->get();
       
        $actions_with_data = $actions->filter(function($action) {
            return (bool) $action->data;
        });

        $actions_without_data = $actions->filter(function($action) {
            return !$action->data;
        })->lists('short_description', 'id');

        return view('admin.wampiriada.show_edition', array(
            'edition' => $number,
            'actions' => $actions_with_data,
            'choices' => $actions_without_data,
            'summary' => new CollectionAggregator($actions_with_data),
        ));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit(Request $request, $id) {
        $action = Action::findOrFail($id);

        $action_data = $action->data;
        if(!$action_data) {
            $action_data = new ActionData;
        }

        return view('admin.wampiriada.edit', array(
            'action' => $action,
            'data' => $action_data,
        ));
	}

    public function postEdit(Request $request, $id) {
        $action = Action::findOrFail($id);

        $action_data = $action->data;
        if(!$action_data) {
            $action_data = new ActionData;
            $action_data->id = $id;
        }

        $action_data->a_plus = $request->input('a_plus', 0);
        $action_data->a_minus = $request->input('a_minus', 0);
        $action_data->b_plus = $request->input('b_plus', 0);
        $action_data->b_minus = $request->input('b_minus', 0);
        $action_data->ab_plus = $request->input('ab_plus', 0);
        $action_data->ab_minus = $request->input('ab_minus', 0);
        $action_data->zero_plus = $request->input('zero_plus', 0);
        $action_data->zero_minus = $request->input('zero_minus', 0);
        $action_data->unknown = $request->input('unknown', 0);
   
        $action_data->save();

        return redirect('admin/wampiriada/show/' . $action->number);
    }

	public function postResults(Request $request) {
	    return redirect('admin/wampiriada/edit/' . $request->input('id'));
    }

}
