<?php namespace NZS\Core\Polls;

use Illuminate\Database\Eloquent\Model as Model;
use NZS\Core\Contracts\PollProxy;

class Poll extends Model implements PollProxy {
    protected $class;

    public function getPollClass() {
        if($this->class) {
            return $this->class;
        }

        $this->class = app()->make($this->class_name);

        return $this->class;
    }

    public function getPoll() {
        return $this;
    }

    public function resolveInterface($contract) {
        return $this->getPollClass()->resolveInterface($contract, $this);
    }

    public function url() {
        return url('routes' . $this->key);
    }
}
