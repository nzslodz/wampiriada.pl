<?php namespace App\Libraries;

use Exception;
use Mail;
use App;

class ErrorMailer {
	protected $dontReport;

	public function __construct(array $dontReport=[]) {
		$this->dontReport = $dontReport;
	}

	public function mailException(Exception $e, array $context=null) {
		foreach($this->dontReport as $class_name) {
			if ($e instanceof $class_name) {
				return;
			}
		}

		try {
			// Mailer could not exist
			Mail::send('emails.exception', ['exception' => $e, 'context' => $context], function($m) use($e) {
				$env = App::environment();

				$m->to('michalmoroz@gmail.com', 'Michał Moroz')
					->from('debug@wampiriada.pl', 'Wampiriada')
					->subject("wampiriada-$env: {$e->getMessage()} thrown at {$e->getFile()}:{$e->getLine()}");
			});
		} catch(Exception $e) {
			return;
		}
	}

	public function mail($message, array $context) {
		try {
			throw new Exception($message);
		} catch (Exception $e) {
			$this->mailException($e, $context);
		};
	}
}
