<?php namespace NZS\Wampiriada\Redirects;

use NZS\Core\Person;
use NZS\Core\Contracts\RedirectRepository;
use NZS\Core\Redirects\BaseRedirectRepository;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaign;
use NZS\Wampiriada\Mailing\Campaigns\EmailCampaignResult;
use Purl\Url;
use Illuminate\Http\Request;

class AwareRedirectRepository extends BaseRedirectRepository {
	protected
		$repository,
		$user,
		$campaign,
		$campaign_key;

	public function __construct(RedirectRepository $repository, Person $user, $campaign) {
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
		$email_campaign = EmailCampaign::where('key', $request->input('c'))->first();
		if(!$email_campaign) {
			return null;
		}

		$user = Person::whereCampaignToken($request->input('m'))->first();
		if(!$user) {
			return null;
		}

		if($user->application_user && $user->application_user->is_staff) {
			//return null;
		}

		return new static($repository, $user, $email_campaign);
	}

	public function getUser() {
		return $this->user;
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

		$url->query->set('m', $this->user->campaign_token);
		$url->query->set('c', $this->campaign_key);

		return $url;
	}

	public function getRedirectObject($name) {
		return $this->repository->getRedirectObject($name);
	}

	public function saveEmailCampaignInfo($name) {
		$redirect = $this->getRedirectObject($name);

		EmailCampaignResult::firstOrCreate([
			'user_id' => $this->user->id,
			'campaign_id' => $this->campaign->id,
			'redirect_id' => $redirect->id,
		]);
	}

	public function registerRedirect($key, $url, $options=[]) {
		$this->repository->registerRedirect($key, $url, $options);
	}
}