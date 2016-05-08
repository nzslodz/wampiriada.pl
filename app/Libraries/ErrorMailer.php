<?php namespace App\Libraries;

use Exception;
use Mail;

class ErrorMailer {
	public static function mailException(Exception $e, array $context=null) {
		Mail::send('emails.exception', ['exception' => $e, 'context' => $context], function($m) use($e) {
			$m->to('michalmoroz@gmail.com', 'Michał Moroz')
				->from('debug@wampiriada.pl', 'Wampiriada')
				->subject("wampiriada: {$e->getMessage()} thrown at {$e->getFile()}:{$e->getLine()}");
		});
	}

	public static function mail($message, array $context) {
		try {
			throw new Exception($message);
		} catch (Exception $e) {
			static::mailException($e, $context);
		};
	}
}