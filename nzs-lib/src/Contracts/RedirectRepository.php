<?php namespace NZS\Core\Contracts;

interface RedirectRepository {
    public function getRedirect($name);
    public function registerRedirect($name, $url, $options=[]);
    public function resolveRedirect($name);
    public function exists($name);
    public function getRedirectAsTag($name, $contents, array $attrs=[]);
    public function generateUrl($name);
    public function getRedirectObject($name);
}
