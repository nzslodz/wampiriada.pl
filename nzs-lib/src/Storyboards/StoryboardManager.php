<?php namespace NZS\Core\Storyboards;
use Illuminate\Http\Request;

class StoryboardManager {
    protected $request;
    protected $storyboard = null;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function getStoryboard() {
        if($this->storyboard === null) {
            $controller = $this->request->route()->getController();
            $this->storyboard = $controller->getStoryboard($controller);
        }

        return $this->storyboard;
    }

    public function choices($parameter) {
        return $this->getStoryboard()->getChoiceCollection($parameter);
    }

    public function is($parameter, $value) {
        return $this->getStoryboard()->is($this->request, $parameter, $value);
    }

    public function isDefault($parameter) {
        return $this->getStoryboard()->isDefault($this->request, $parameter);
    }

    public function value($parameter) {
        return $this->getStoryboard()->value($this->request, $parameter);
    }
}
