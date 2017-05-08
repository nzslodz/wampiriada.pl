<?php namespace NZS\Core\Storyboards;

use RuntimeException;

class Transition {
    protected $value;
    protected $transition;
    protected $text = null;
    protected $is_default = false;

    public function __construct($value, $transition) {
        $this->value = $value;
        $this->transition = $transition;
    }

    public function setDefault() {
        $this->is_default = true;
    }

    public function isDefault() {
        return $this->is_default;
    }

    public function compareValue($value) {
        return $this->value == $value;
    }

    public function getTransitionFunction() {
        return $this->transition;
    }

    public function withText($text) {
        $this->text = $text;

        return $this;
    }

    public function __toString() {
        if($this->text === null) {
            throw new RuntimeException("Transition $this->value does not have its text set. Use withText() method.");
        }

        return $this->text;
    }
}
