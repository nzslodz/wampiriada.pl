<?php namespace NZS\Core;

use Illuminate\Database\Eloquent\Model as Model;

class Activity extends Model {
    protected $class;

    public function getActivityClass() {
        if($this->class) {
            return $this->class;
        }

        $this->class = app()->make($this->class_name);

        return $this->class;
    }

    public function resolveInterface($contract) {
        return $this->getActivityClass()->resolveInterface($contract, $this);
    }
}
