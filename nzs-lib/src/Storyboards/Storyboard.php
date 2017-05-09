<?php namespace NZS\Core\Storyboards;
use NZS\Core\Storyboards\Transition;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use LogicException;

class Storyboard {
    protected $managed_parameters;
    protected $controller;
    protected $use_session = false;

    public function __construct(Controller $controller) {
        $this->managed_parameters = collect();
        $this->controller = $controller;
    }

    public function getController() {
        return $this->controller;
    }

    /* XXX what is param? baby dont hurt me */
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

    protected function getSessionKey($parameter) {
        return sprintf("storyboard::%s.%s", get_class($this->getController()), $parameter);
    }

    protected function getValueFromRequest(Request $request, $parameter) {
        if($request->has($parameter)) {
            return $request->get($parameter);
        }

        if($this->use_session) {
            $session_key = $this->getSessionKey($parameter);

            if($request->session()->has($session_key)) {
                return $request->session()->get($session_key);
            }
        }

        return false;
    }

    protected function matches(Transition $transition, $value) {
        if($transition->isDefault()) {
            return true;
        }

        if($transition->compareValue($value)) {
            return true;
        }

        return false;
    }

    protected function findTransition(Request $request, $parameter=null) {
        $managed = $this->managed_parameters;

        if($parameter) {
            $managed = $managed->only([$parameter]);
        }

        foreach($managed as $parameter => $transitions) {
            $value = $this->getValueFromRequest($request, $parameter);

            if($value === false) {
                continue;
            }

            foreach($transitions as $transition) {
                if($this->matches($transition, $value)) {
                    return $transition;
                }
            }
        }

        throw new LogicException("Storyboard tried to find matching transition, but reached no conclusion.");
    }

    public function getChoiceCollection($parameter) {
        return $this->managed_parameters->get($parameter, collect())->mapWithKeys(function($transition) {
            return [$transition->getValue() => $transition];
        });
    }

    public function is(Request $request, $parameter, $value) {
        return $this->findTransition($request, $parameter)->compareValue($value);
    }

    public function isDefault(Request $request, $parameter) {
        return $this->findTransition($request, $parameter)->isDefault();
    }

    protected function decorate(Request $request, Response $response, Transition $transition) {
        /*if($this->use_session) {
            $reqeust->session()->put($this->);
        }*/

        return $response;
    }

    public function response(Request $request, ...$args) {
        $function = $this->findTransition($request)->getTransitionFunction();

        $response = $function($request, ...$args);

        return $this->decorate($request, $response, $transition);
    }
}
