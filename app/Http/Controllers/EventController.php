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
    private $NOT_STATUS = ['yes','no'];

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

        Session::flash('flash_message', 'Event successfully created');

        return redirect()->back();
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
        $event_notification = $this->NOT_STATUS[$event->send_notification];
        $event_is_active = $this->NOT_STATUS[$event->is_active];

        return view('events.view', [
            'event' => $event,
            'event_notification' => $event_notification,
            'event_is_active' => $event_is_active,
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
        $user_created_events = Event::where('user_id',Auth::user()->id)->get();
        $user_signed_events = Auth::user()->events->union($user_created_events);

        $this_event = Event::findOrFail($id);

        Session::flash('view_userevents', true);


        $event_not = ($this_event->send_notification == true ? "yes" : "no");

        return view('events.edit', [
            'events' => $user_signed_events,
            'this_event' => $this_event,
            'statuses' => $this->STATUSES,
            'send_notification' => $this->NOT_STATUS,
            'event_not' => $event_not,
            'created_events' => $user_created_events,
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

        if($request->action_type=="edit")
        {
            $this->validate($request, [
                'name' => 'required',
                'event_from_date' => 'required',
                'event_to_date' => 'required',
                'location' => 'required',
                'description' => 'required',
                'description' => 'required',
                'send_notification' => 'required',
            ]);
        }
        else
        {
            $this->validate($request, [
                'name' => 'required',
                'event_from_date' => 'required',
                'event_to_date' => 'required'
            ]);

            $event_from_date = Carbon::parse($request->event_from_date);
            $event_to_date = Carbon::parse($request->event_to_date);

            $event->fill(array(
            "name" => $request->name,
            "event_from_date" => $event_from_date,
            "event_to_date" => $event_to_date,
            ))->save();

        Session::flash('flash_message', 'Event postponed to date: '.$event_from_date);

        return redirect()->back();
        }

        $input = $request->all();

        $send_notification = ($request->send_notification == 'yes' ? true : false);
        $is_active = ($request->status == 'yes' ? true : false);


        $event_from_date = Carbon::parse($request->event_from_date);
        $event_to_date = Carbon::parse($request->event_to_date);

        $event->fill(array(
            "name" => $request->name,
            "event_from_date" => $event_from_date,
            "event_to_date" => $event_to_date,
            "location" => $request->location,
            "description" => $request->description,
            "send_notification" => $send_notification
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
    public function userevents()
    {
        
        $user_created_events = Event::where('user_id',Auth::user()->id)->get();
        $user_signed_events = Auth::user()->events;

        Session::flash('view_userevents', true);

        return view('events.index', [
            'events' => $user_signed_events,
            'created_events' => $user_created_events,
        ]);
    }

    /**
     * Get events for a selected user.
     *
     * @param  int  $id
     * @return Response
     */
    public function getuserevents($userid)
    {
        $user = User::findOrFail($userid);
        $user_created_events = Event::where('user_id',Auth::user()->id)->get();
        $user_signed_events = $user->events;

        Session::flash('view_getuserevents', true);

        return view('events.index', [
            'events' => $user_signed_events,
            'created_events' => $user_created_events,
            'sel_user' => $user,
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

        $event_notification = $this->NOT_STATUS[$event->send_notification];
        $event_is_active = $this->NOT_STATUS[$event->is_active];

        return view('events.view', [
            'event' => $event,
            'is_registered'=>$event->users->contains(Auth::user()),
            'event_notification' => $event_notification,
            'event_is_active' => $event_is_active,
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

        $event_notification = $this->NOT_STATUS[$event->send_notification];
        $event_is_active = $this->NOT_STATUS[$event->is_active];

        return view('events.message', [
            'event' => $event,
            'is_registered'=>$event->users->contains(Auth::user()),
            'event_notification' => $event_notification,
            'event_is_active' => $event_is_active,
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

        // get app all participants
        // If no users return, else send message
        $participants = array();
        if(count($event->users)>0)
        {
            $i=0;
            foreach($event->users as $user)
            {
                $participants[$i] = $user->email;
                $i++;
            }
        }
        else
        {
            Session::flash('mail_message', 'No participants for this event');

            return redirect()->back();
        }

        $emails = $participants;
        $subject_body = "Alerts on Event: ".$event->name;
        $message_body = $request->message;

        $mail_data = array(
            "subject"=>$subject_body,
            "body"=>$message_body,
            "participants"=>$participants,
            );

        Mail::send([], [], function ($message) use ($mail_data) {
          $message->to($mail_data['participants'])
            ->subject($mail_data['subject'])
            // here comes what you want
            ->setBody($mail_data['body']);
        });

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
