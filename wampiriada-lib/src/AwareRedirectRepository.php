<?php namespace NZS\Wampiriada;

use App\User;

class AwareRedirectRepository {
	protected
		$repository,
		$user,
		$campaign;

	public function __construct(EditionRepository $repository, User $user, $key) {
		$this->repository = $repository;
		$this->user = $user;

		$this->key = 'w' . $this->repository->getEditionNumber() . ':' . $key;
	}

	public function registerRedirect($key, $url, $edition_specific=true) {
		return $this->decorate($this->repository->registerRedirect($key, $url, $edition_specific));
	}

	protected function decorate($redirect) {
		return (new AwareRedirect($redirect))->withCampaign($this->getEmailCampaign())->withUser($this->user);
	}

	public function getEmailCampaign() {
		if($this->campaign) {
			return $this->campaign;
		}

		$this->campaign = EmailCampaign::firstOrCreate(['key' => $this->key]);
	
		return $this->campaign;
	}

	public function getRedirect($key) {
		return $this->decorate($this->repository->getRedirect($key));
	}
}