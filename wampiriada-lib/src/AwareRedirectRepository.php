<?php namespace NZS\Wampiriada;

use App\User;
use NZS\Core\Contracts\RedirectRepository;
use NZS\Core\Redirects\BaseRedirectRepository;
use NZS\Wampiriada\EmailCampaign;
use Purl\Url;
use Illuminate\Http\Request;

class AwareRedirectRepository extends BaseRedirectRepository {
	protected
		$repository,
		$user,
		$campaign,
		$campaign_key;

	public function __construct(RedirectRepository $repository, User $user, $campaign) {
		$this->repository = $repository;
		$this->user = $user;

		if($campaign instanceof EmailCampaign) {
			$this->campaign_key = $campaign->key;
			$this->campaign = $campaign;
		} else {
			$this->campaign_key = $campaign;
		}
	}

	public static function fromRequest(Request $request, RedirectRepository $repository) {
		$email_campaign = EmailCampaign::whereKey($request->input('c'))->first();
		if(!$email_campaign) {
			return null;
		}

		$user = User::whereMd5email($request->input('m'))->first();
		if(!$user) {
			return null;
		}

		return new static($repository, $user, $campaign);
	}

	public function getEmailCampaign() {
		if($this->campaign) {
			return $this->campaign;
		}

		$this->campaign = EmailCampaign::firstOrCreate(['key' => $this->campaign_key]);

		return $this->campaign;
	}

	public function resolveRedirect($name) {
		$this->repository->resolveRedirect($name);
	}

	public function exists($name) {
		$this->repository->exists($name);
	}

	public function generateUrl($name) {
		$url = $this->repository->generateUrl($name);

		if(!($url instanceof Url)) {
			return '';
		}

		$url->query->set('m', $this->user->md5_email);
		$url->query->set('c', $this->campaign_key);

		return $url;
	}

	public function getRedirectObject($name) {
		return $this->repository->getRedirectObject($name);
	}

	public function saveEmailCampaignInfo($name) {
		$redirect = $this->getRedirectObject();

		EmailCampaignResult::firstOrCreate([
			'user_id' => $user->id,
			'campaign_id' => $email_campaign->id,
			'redirect_id' => $redirect->id,
		]);
	}

	public function registerRedirect($key, $url, $options=[]) {
		$this->repository->registerRedirect($key, $url, $options);
	}
}
