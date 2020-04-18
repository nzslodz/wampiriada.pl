<?php namespace NZS\Core\EmailAccounts;

use DB;

use Illuminate\Support\Str;

class EmailRepository {
	protected
		$domain;

	public function __construct($domain) {
		$this->domain = $domain;
	}

	public function getList() {
		return ViewEntry::where('address', 'LIKE', "%@$this->domain")->where('address', '!=', DB::raw('goto'))->get();
	}

	public function add($email, $password, $alias_email=null) {
		if(!Str::endsWith($email, "@$this->domain")) {
			throw new \LogicException("Email $email does not end with domain $this->domain");
		}

		$mailbox = new Mailbox;

		$mailbox->name = $email;
		$mailbox->maildir = "$email/";
		$mailbox->domain = $this->domain;
		$mailbox->password = $password;
		$mailbox->username = $email;
		$mailbox->active = 1;

		$mailbox->save();

		if(!$alias_email) {
			return;
		}

		$alias = new Alias;
		$alias->address = $email;
		$alias->goto = $alias_email;
		$alias->active = 1;
		$alias->save();
	}
}
