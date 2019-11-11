<?php namespace NZS\Core\Redirects;

use Netzmacht\Html\Factory\ElementFactory;

trait AsTagTrait {
    public function asTag($contents, array $attrs=[]) {
        if(!$this->exists()) {
            return $contents;
        }

        $attrs['href'] = $this->asUrl();

        $factory  = new ElementFactory();

        return $factory->create('a', $attrs)->addChild($contents);
    }
}
