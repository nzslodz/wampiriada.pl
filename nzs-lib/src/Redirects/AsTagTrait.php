<?php namespace NZS\Core\Redirects;

use Netzmacht\Html\Element;

trait AsTagTrait {
    public function asTag($contents, array $attrs=[]) {
        if(!$this->exists()) {
            return $contents;
        }

        $attrs['href'] = $this->asUrl();

        return Element::create('a', $attrs)->addChild($contents);
    }
}
