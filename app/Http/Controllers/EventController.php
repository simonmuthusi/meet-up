<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use Auth;
use Carbon\Carbon;
use Session;
use Mail;

class EventController extends Controller {
    private $STATUSES = ['draft','not attending','attending'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $events = Event::orderBy('created_at', 'asc')
        ->where('is_active',true)
        ->get();

        return view('events.index', [
            'events' => $events,
            'statuses' => $this->STATUSES
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'event_from_date' => 'required',
            'event_to_date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'send_notification' => 'required',
        ]);

        $send_notification = ($request->send_notification == 'yes' ? true : false);
        $is_active = ($request->status == 'yes' ? true : false);

        $input = $request->all();
        $event_from_date = Carbon::parse($request->event_from_date);
        $event_to_date = Carbon::parse($request->event_to_date);

        $event = Event::create(array(
            "name" => $request->name,
            "event_from_date" => $event_from_date,
            "event_to_date" => $event_to_date,
            "location" => $request->location,
            "description" => $request->description,
            "attachment" => $request->attachment,
            "status" => "draft",
            "send_notification" => $send_notification,
            "is_active" => $is_active,
            "user_id" => Auth::user()->id
            ));

        $event->user_id = Auth::user()->id;
        $event->save();
        // $event = new Event::create(array(
        //     "name" => $request->name,
        //     "event_from_date" => Carbon::now(),
        //     "event_to_date" => Carbon::now(),
        //     "location" => $request->location,
        //     "description" => $request->description,
        //     "attachment" => $request->attachment,
        //     "status" => "draft",
        //     "send_notification" => $request->send_notification
        //     ));
        // $event = new Event();
        // $event->name = $request->name;
        // $event->event_from_date = Carbon::now();
        // $event->event_to_date = Carbon::now();
        // $event->location = $request->location;
        // $event->description = $request->description;
        // $event->attachment = $request->attachment;
        // $event->status ="draft";
        // $event->send_notification = $request->send_notification;
        // $event->user()->associate(Auth::user());
        // $event->save();

        // $event->users.save(Auth::user());
        // $event->users()->attach(Auth::user());

        Session::flash('flash_message', 'Event successfully created');

        return redirect()->back();
        // dd($request->description);

        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.view', [
            'event' => $event,
            'is_registered'=>$event->users->contains(Auth::user())
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $events = Event::orderBy('created_at', 'asc')
        ->where('is_active',true)
        ->get();

        $this_event = Event::findOrFail($id);

        return view('events.edit', [
            'events' => $events,
            'this_event' => $this_event,
            'statuses' => $this->STATUSES
        ]);

        // return view('events.edit')->withTask($event);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $event = Event::findOrFail($id);

        $this->validate($request, [
            'name' => 'required',
            'event_from_date' => 'required',
            'event_to_date' => 'required',
            'location' => 'required',
            'description' => 'required',
            'description' => 'required',
            'send_notification' => 'required',
        ]);

        $input = $request->all();

        
        $event_from_date = Carbon::parse($request->event_from_date);
        $event_to_date = Carbon::parse($request->event_to_date);

        $event->fill(array(
            "name" => $request->name,
            "event_from_date" => $event_from_date,
            "event_to_date" => $event_to_date,
            "location" => $request->location,
            "description" => $request->description,
            "attachment" => $request->attachment,
            "status" => "draft",
            "send_notification" => $request->send_notification
            ))->save();

        Session::flash('flash_message', 'Event successfully updated');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get logged in user events.
     *
     * @param  int  $id
     * @return Response
     */
    public function userevents($id)
    {
        return view('events.index', [
            'events' => Auth::user()->events
        ]);
    }

    /*
     * Activate event.
     *
     * @param  int  $id
     * @return Response
     */
    public function activate($eventid)
    {
        $event = Event::findOrFail($eventid);
        $is_active = !$event->is_active;
        $event->is_active = $is_active;
        $event->save();

        return view('events.view', [
            'event' => $event,
            'is_registered'=>$event->users->contains(Auth::user())
        ]);
    }

    /*
     * Postpone event
     *
     * @param  int  $id
     * @return Response
     */
    public function postpone($eventid)
    {
        // $event = Event::findOrFail($id);
        Session::flash('postpone', true);

        return view('events.edit', [
            'events' => Event::orderBy('created_at', 'asc')->get(),
            'this_event' =>Event::findOrFail($eventid)
        ]);

        // return view('events.edit')->withTask($event);

    }

    /*
     * Postpone event
     *
     * @param  int  $id
     * @return Response
     */
    public function message($eventid)
    {
        
        $event = Event::findOrFail($eventid);
        $is_active = !$event->is_active;
        $event->is_active = $is_active;
        $event->save();

        return view('events.message', [
            'event' => $event,
            'is_registered'=>$event->users->contains(Auth::user())
        ]);

    }

    /**
     * Email participants of a given event
     *
     * @param  int  $id
     * @return Response
     */
    public function emailparticipants($eventid, Request $request)
    {
        $event = Event::findOrFail($eventid);

        $this->validate($request, [
            'message' => 'required',
        ]);

        $input = $request->all();

        $emails = ["simonmuthusi@gmail.com"];
        $subject = "Alerts on Event: "+$event->name;

        // Mail::send('emails.lead', [], function($message) use ($emails, $subject)
        // {    
        //     $message->to($emails)->subject($subject);    
        // });
        // Mail::send('emails.reminder', [], function ($m) use ($subject) {
        //     $m->from('hello@app.com', 'Your Application');

        //     $m->to("simonmuthusi@gmail.com", "Simon Muthusi")->subject('Your Reminder!');
        // });

        Session::flash('mail_message', 'message send successfully');

        return redirect()->back();
    }

    /*
     * User register for event
     *
     * @param  int  $id
     * @return Response
     */
    public function user_register($eventid)
    {
        $event = Event::findOrFail($eventid);
        // $event->users()->associate(Auth::user());
        // $event->users.save(Auth::user());
        if($event->users()->exists(Auth::user()))
        {
            $event->users()->detach(Auth::user());
        }
        else
        {
            $event->users()->attach(Auth::user());
        }
        $event->save();
        return redirect()->back();

        // $is_active = !$event->is_active;
        // $event->is_active = $is_active;
        // $event->save();

        return view('events.view', [
            'event' => $event,
            'is_registered'=>$event->users->contains(Auth::user())
        ]);
    }


}