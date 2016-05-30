<?php namespace NZS\Core\EmailAccounts;

use Illuminate\Database\Eloquent\Model as Model;

class Mailbox extends Model {
	protected $table = 'mailbox';
    protected $connection = 'mysql-postfix';
}