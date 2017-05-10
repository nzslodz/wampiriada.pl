<?php namespace NZS\Core\Storyboards;

/*

Use with the following code:

    public function getStoryboard() {
        return (new DjangoAdminStyleStoryboard($this))
            ->withRoutes('admin-prize-list', 'admin-prize-edit', 'admin-prize-create')
            ->withTexts('Zapisz', 'Zapisz i kontynuuj edycję', 'Zapisz i dodaj następny');
    }

    public function postEdit(PrizeTypeRequest $request, $id=null) {
        [...]
        return $this->getStoryboard()
            ->response($request, $type)
            ->with('status', 'success')
            ->with('message', 'Typ nagrody poprawnie zapisany');
    }

view.blade.php:

    @foreach(storyboard()->choices('_save') as $value => $transition)
        <button class="btn btn-default" name="_save" type="submit" value="{{ $value }}">{{ $transition }}</button>
    @endforeach

*/

class DjangoAdminStyleStoryboard extends Storyboard {
    protected $list_route;
    protected $edit_route;
    protected $create_route;

    protected $save_text = "Save";
    protected $save_and_add_another_text = "Save and add another";
    protected $save_and_continue_editing_text = "Save and continue editing";

    protected function configure() {
        $this->addTransitionOn('_save', 'save-and-add-another', function() {
            return redirect()->route($this->create_route);
        })->withText(function() {
            return $this->save_and_add_another_text;
        });

        $this->addTransitionOn('_save', 'save-and-continue', function($request, $object) {
            return redirect()->route($this->edit_route, [$object]);
        })->withText(function() {
            return $this->save_and_continue_editing_text;
        });

        $this->addDefaultTransition('_save', function() {
            return redirect()->route($this->list_route);
        })->withText(function() {
            return $this->save_text;
        });
    }

    public function withRoutes($list_route, $edit_route, $create_route) {
        $this->list_route = $list_route;
        $this->edit_route = $edit_route;
        $this->create_route = $create_route;

        return $this;
    }

    public function withTexts($save_text, $save_and_continue_editing_text, $save_and_add_another_text) {
        $this->save_text = $save_text;
        $this->save_and_add_another_text = $save_and_add_another_text;
        $this->save_and_continue_editing_text = $save_and_continue_editing_text;

        return $this;
    }
}
