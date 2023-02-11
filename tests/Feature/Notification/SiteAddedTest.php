<?php

namespace Tests\Feature\Notification;

use App\Models\User;
use App\Notifications\SiteAdded;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SiteAddedTest extends TestCase
{
  public function test_send_correct_message()
  {
    $user = User::factory()->create();

    $site = $user->site()->save(Site::factory()->make());

    $notification = new SiteAdded($site);
    $message = $notification->toMail($user);

    $this->assertEquals("Hello {$user->name},", $message->introLines[0]);
    $this->assertEquals("We are just informing that the site {$site->url} was added to your account", $message->introLines[1]);
    $this->assertEquals('See Site', $message->actionText);
    // $this->assertEquals(route('sites.show', $site), $message->actionUrl);
    $this->assertEquals('New site added to your account', $message->subject);
  }
}
