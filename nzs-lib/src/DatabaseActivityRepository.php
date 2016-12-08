<?php namespace NZS\Core;

use Illuminate\Database\Migrations\MigrationRepositoryInterface;

class DatabaseActivityRepository implements ActivityRepository {
    protected $activity_classes = [];

    protected $migration_repository;

    protected $migration_ran = null;

    public function __construct(MigrationRepositoryInterface $repository) {
        $this->migration_repository = $repository;
    }

    public function append($class_names) {
        if(!is_array($class_names)) {
            $class_names = [$class_names];
        }

        foreach($class_names as $activity_class) {
            $this->activity_classes[$activity_class->getModel()] = $activity_class;
        }
    }

    public function getByModelClass($class_name) {
        return $this->activity_classes[$class_name];
    }

    // XXX add config option
    public function hasMigrationRan() {
        if($this->migration_ran !== null) {
            return $this->migration_ran;
        }

        $this->migration_ran = in_array('2016_06_05_123302_add_activity_table', $this->migration_repository->getRan());

        return $this->migration_ran;
    }

    public function registerActivityEvents() {
        if(!$this->hasMigrationRan()) {
            return;
        }

        foreach ($this->activity_classes as $activity_class) {
            $activity_class->registerActivityEvent();
        }
    }
}
