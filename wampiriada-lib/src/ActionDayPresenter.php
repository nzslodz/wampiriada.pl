<?php namespace NZS\Wampiriada;

use Laracodes\Presenter\Presenter;

class ActionDayPresenter extends Presenter {
    public function place() {
        return $this->model->place->name;
    }

    public function schoolShort() {
        return $this->model->place->school->short_name;
    }

    public function school() {
        return $this->model->place->school->name;
    }

    public function lat() {
        return $this->model->place->lat;
    }

    public function lng() {
        return $this->model->place->lng;
    }

    public function address() {
        return $this->model->place->address;
    }

    public function mobileJson() {
        return [
            'place_name' => $this->place(),
            'place_address' => $this->address(),
            'start' => $this->model->start->format('H:i'),
            'end' => $this->model->end->format('H:i'),
            'day' => $this->model->created_at->format('d-m-Y'),
        ];
    }
}
