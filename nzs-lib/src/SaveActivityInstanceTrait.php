<?php namespace NZS\Core;

use LogicException;

trait SaveActivityInstanceTrait {
    public function getUserId($object) {
        return $object->user_id;
    }

    public function getCreatedAt($object) {
        return $object->created_at;
    }

    public function saveActivityInstance($object) {
        $activity = new Activity();
        $activity->class_name = get_class($this);

        $activity->user_id = $this->getUserId($object);
        if(!$activity->user_id) {
            throw new LogicException("Object passed to saveActivityInstance must have user_id or getUser() method implemented");
        }

        $created_at = $this->getCreatedAt($object);
        if($created_at) {
            $activity->created_at = $created_at;
        }

        $activity->save();

        return $activity;
    }
}
