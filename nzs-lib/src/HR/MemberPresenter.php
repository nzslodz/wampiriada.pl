<?php namespace NZS\Core\HR;

use Laracodes\Presenter\Presenter;
use NZS\Core\FontAwesomeIcon;

class MemberPresenter extends Presenter {
    public function email() {
        return $this->model->user->email;
    }

    public function fullName() {
        return $this->model->user->getFullName();
    }

    public function memberSince() {
        if($this->model->member_since === null) {
            return '';
        }

        return $this->model->member_since->diffForHumans();
    }

    public function hasBadgeIcon() {
        return (new FontAwesomeIcon('star', 'Posiada przypinkę NZSu'))->successOrDanger($this->model->has_badge);
    }

    public function isMemberIcon() {
        return (new FontAwesomeIcon('user', 'Jest członkiem NZSu'))->successOrDanger($this->model->is_member);
    }
}
