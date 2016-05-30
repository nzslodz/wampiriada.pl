<?php namespace NZS\Core\EmailAccounts;

use Illuminate\Database\Eloquent\Model as Model;

class Alias extends Model {
    protected $table = 'alias';
    protected $connection = 'mysql-postfix';
}