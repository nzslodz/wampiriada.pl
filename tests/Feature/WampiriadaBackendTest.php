<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use NZS\Core\ApplicationUser;

class WampiriadaBackendTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetOnBackendSites()
    {
        $user = ApplicationUser::whereEmail('nzs@nzs.lodz.pl')->first();

        $this->actingAs($user)
            ->get('/admin/')
            ->assertStatus(200);

        //

        $this->actingAs($user)
            ->get('/admin/wampiriada/show/32')
            ->assertStatus(200);

        //
        $this->actingAs($user)
            ->get('/admin/wampiriada/edit/283')
            ->assertStatus(200);

        //
        $this->actingAs($user)
            ->get('/admin/wampiriada/settings/32')
            ->assertStatus(200);

        //
        $this->actingAs($user)
            ->get('/admin/mailing/preview?class=NZS\Wampiriada\Mailing\WampiriadaThankYouMailingComposer')
            ->assertStatus(200);

        //
        $this->actingAs($user)
            ->get('/admin/mailing/preview?class=NZS\Wampiriada\Mailing\WampiriadaSummaryMailingComposer')
            ->assertStatus(200);

        //
        $this->actingAs($user)
            ->get('/admin/mailing/preview?class=NZS\Wampiriada\Mailing\WampiriadaReminderMailingComposer')
            ->assertStatus(200);

        //

        $this->actingAs($user)
            ->get('/admin/mailing/preview?class=NZS\Wampiriada\Mailing\WampiriadaAnnouncementMailingComposer')
            ->assertStatus(200);

        //

        $this->actingAs($user)
            ->get('/admin/wampiriada/prize/summary/32')
            ->assertStatus(200);

        //
    }
}
