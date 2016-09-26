<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Event;
use App\User;

class EventControllerTest extends TestCase
{
	public function setUp()
	{
	    parent::setUp();

	    $event = User::create(array(
            "name" => "john",
            "event_from_date" => $now,
            "event_to_date" => $now,
            "location" => "nairobi",
            "description" => "this is description",
            "attachment" => null,
            "status" => "draft",
            "send_notification" => false,
            "user_id" => $user->id
            ));

	    $now = Carbon::now();

	    $event = Event::create(array(
            "name" => "john",
            "event_from_date" => $now,
            "event_to_date" => $now,
            "location" => "nairobi",
            "description" => "this is description",
            "attachment" => null,
            "status" => "draft",
            "send_notification" => false,
            "user_id" => $user->id
            ));

        $event->user_id = $user->id;
        $event->save();



	}

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /**
     * Test index
     *
     * @return void
     */
    public function testIndex()
    {
        // Event::shouldReceive('all')->once();
 
        // $this->call('GET', 'events');
 
        // $this->assertViewHas('events');
        Auth::shouldReceive('check')->once()->andReturn(false);

        $this->call('GET', 'home');

        $this->assertResponseOk();
    }
}
