<?php namespace NZS\Core\Storyboards;
use NZS\Core\Storyboards\Transition;

class Storyboard {
    protected $managed_parameters;
    protected $use_session = false;

    public function __construct() {
        $this->managed_parameters = collect();
    }

    public function addTransitionOn($parameter, $value, $transition) {
        if(!isset($this->managed_parameters[$parameter])) {
            $this->managed_parameters[$parameter] = collect();
        }

        $transition = new Transition($value, $transition);

        $this->managed_parameters[$parameter]->push($transition);

        return $transition;
    }

    public function addDefaultTransition($parameter, $transition) {
        return $this->addTransitionOn($parameter, null, $transition)->setDefault();
    }

    public function useSession() {
        $this->use_session = true;
    }

    protected function findTransition() {

    }

    public function getChoiceCollection($parameter) {
    }

    public function is($request, $parameter, $value) {
        return $this->findTransition($request, $parameter)->compareValue($value);
    }

    public function isDefault($request, $parameter) {
        return $this->findTransition($request, $parameter)->isDefault();
    }

    public function response($request, ...$args) {
        $function = $this->findTransition($request)->getTransitionFunction();

        return $this->decorate($function($request, ...$args));
    }

    public function responseFor($request, $parameter, ...$args) {
        $function = $this->findTransition($request, $parameter)->getTransitionFunction();

        return $this->decorate($function($request))
    }
}
