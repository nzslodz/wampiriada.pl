<?php namespace App\Http\Controllers;

use NZS\Core\CollectionAggregator;
use NZS\Wampiriada\Option;
use NZS\Wampiriada\Action;
use NZS\Wampiriada\ActionData;
use NZS\Wampiriada\FacebookConncection;
use NZS\Wampiriada\Editions\Edition;
use NZS\Wampiriada\Checkins\Checkin;
use NZS\Wampiriada\ShirtSize;
use NZS\Wampiriada\Redirect;
use DB;

use NZS\Core\EmailAccounts\EmailRepository;
use NZS\Core\EmailAccounts\AddEmailAccountRequest;

use Illuminate\Http\Request;

use Mail;

class MailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex() {
        $repository = new EmailRepository('nzs.lodz.pl');

        return view('admin.email_accounts.list', [
            'accounts' => $repository->getList(),
        ]);
	}

    public function getCreate() {
        return view('admin.email_accounts.create');
    }

    public function postCreate(AddEmailAccountRequest $request) {
        $repository = new EmailRepository('nzs.lodz.pl');

        try {
            $repository->add($request->email, $request->password, $request->alias_email);
        } catch (\LogicException $e) {
            return redirect()->back()->with('status', 'danger')->with('message', 'Zmień adres e-mailowy na adres kończący się w domenie @nzs.lodz.pl')->withInput();
        }

        return redirect('/admin/email/');
    }

}
