<?php namespace NZS\Core\Mailing;

class MailingRepository {
    protected $composer_classes = [];

    public function register($composer_classes) {
        if(!is_array($composer_classes)) {
            $composer_classes = [$composer_classes];
        }

        foreach ($composer_classes as $composer_class) {
            $this->composer_classes[] = $composer_class;
        }
    }

    public function filterClassesByInterface($interface_class) {
        return $this->collect()->filter(function($composer_class) use($interface_class) {
            return is_subclass_of($composer_class, $interface_class);
        });
    }

    public function exists($class) {
        return in_array($class, $this->composer_classes);
    }

    public function existsOfInterface($class, $interface_class) {
        return in_array($class, $this->composer_classes) && is_subclass_of($class, $interface_class);
    }

    public function getClassOfInterface($class, $interface_class) {
        if($this->existsOfInterface($class, $interface_class)) {
            return $class;
        }

        return null;
    }

    public function collect() {
        return collect($this->composer_classes);
    }
}
