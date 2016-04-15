<?php namespace NZS\Wampiriada;

/**
 * Trait describing boolean content blocks.
 *
 * In templates, any classes that use this trait can be used as below:
 *
 * <?php $redirect->open() ? >
 *      <a href="<?= $redirect ? >">Hello!</a>
 * <?php $redirect->otherwise() ? >
 *      <p class="note">Nothing to show here. Add redirect to display links.</p>
 * <?php $redirect->close() ? >
 */

trait BooleanBlockTrait {
    protected 
        $contents = [];

    public function open() {
        ob_start();
    }

    public function otherwise() {
        array_push($this->contents, ob_get_clean());
        ob_start();
    }

    public function close() {
        array_push($this->contents, ob_get_clean());
        
        echo $this->isTrue() ? $this->getBlockContents(0) : $this->getBlockContents(1);
    }

    protected function getBlockContents($key) {
        if(!isset($this->contents[$key])) {
            return '';
        }

        return $this->contents[$key];
    }

    abstract protected function isTrue();
}

