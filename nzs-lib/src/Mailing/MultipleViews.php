<?php namespace NZS\Core\Mailing;

use InvalidArgumentException;

trait MultipleViews {
    public function getViews() {
        return $this->views;
    }

    public function getView() {
        foreach($this->getViews() as $view) {
            try {
                // try to instantiate a view. If it fails, try another one.
                view($view);

                return $view;
            } catch(InvalidArgumentException $e) {
            }
        }


        $message = sprintf("None of views [%s] found.", join("; ", $this->getViews()));

        throw new InvalidArgumentException($message);
    }
}
