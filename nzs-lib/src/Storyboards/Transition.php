<?php namespace NZS\Core\Storyboards;

use RuntimeException;

class Transition {
    protected $value;
    protected $transition;
    protected $managed_parameter;
    protected $text = null;
    protected $is_default = false;

    public function __construct($parameter, $value, $transition_function) {
        $this->managed_parameter = $parameter;
        $this->value = $value;
        $this->transition = $transition_function;
    }

    public function setDefault() {
        $this->is_default = true;

        return $this;
    }

    public function isDefault() {
        return $this->is_default;
    }

    public function getManagedParameter() {
        return $this->managed_parameter;
    }

    public function compareValue($value) {
        return $this->value === $value;
    }

    public function getValue() {
        return $this->value;
    }

    public function value() {
        return $this->getValue();
    }

    public function getTransitionFunction() {
        return $this->transition;
    }

    public function getText() {
        if(is_callable($this->text)) {
            return call_user_func($this->text);
        }

        return $this->text;
    }

    public function withText($text) {
        $this->text = $text;

        return $this;
    }

    public function __toString() {
        $text = $this->getText();

        if($text === null) {
            throw new RuntimeException("Transition $this->value does not have its text set. Use withText() method.");
        }

        return $text;
    }
}
