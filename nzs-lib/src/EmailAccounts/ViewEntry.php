<?php namespace NZS\Core\EmailAccounts;

use Illuminate\Database\Eloquent\Model as Model;

class ViewEntry extends Model {
    protected $table = 'aliases_and_mailboxes';

    protected $connection = 'mysql-postfix';

}