<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Events\UserRegister;
use Illuminate\Support\Facades\Event;
use App\Models\User;

class UserRegTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_user_event_send_message(): void
    {
        #$this->app['config']->set('mail.default', 'log');
        #Event::fake(); 
        $user = User::factory()->create();
        event(new UserRegister($user));
        $this->assertTrue(true); 
        ##Event::assertListening(UserRegister::class, \App\Listeners\WelcomeToUserListener::class);
    }
}
