<?php namespace NZS\Core\HR;

use Laracodes\Presenter\Presenter;
use NZS\Core\FontAwesomeIcon;

class EventPresenter extends Presenter {

    public function isPublicIcon() {
        return (new FontAwesomeIcon('check', 'Jest publiczne'))->normalOrNone($this->model->is_public);
    }
}
