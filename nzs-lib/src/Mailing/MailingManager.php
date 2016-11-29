<?php namespace NZS\Core\Mailing;

class MailingManager {
    protected
        $in_preview = true;

    public function isInPreviewMode() {
        return $this->in_preview;
    }

    public function setInPreviewMode() {
        $this->in_preview = true;
    }
}
