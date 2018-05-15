<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsletterRemoveRequest;

use Auth;
use NZS\Wampiriada\Donor;

class NewsletterController extends Controller {
	public function getRemove(Request $request) {
		$email = $request->input('email');

		return view('newsletter.remove', [
			'email' => $email,
		]);
	}

	public function postRemove(NewsletterRemoveRequest $request) {
		$donor = Donor::whereEmail($request->email)->first();

		if(!$donor) {
			return redirect('/newsletter/removed');
		}

		// XXX agree on behaviour
		$donor->email = '';
		$donor->save();

		return redirect('/newsletter/removed');
	}

	public function getRemoveSuccess() {
		return view('newsletter.removal_success');
	}
}
