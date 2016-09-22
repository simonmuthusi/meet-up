<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Carbon\Carbon;
use Session;
/**
class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     *
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     *
    public function index()
    {
        return view('events.create');
    }

    public function create()
    {
        return view('events.create');
    }
}**/

class EventController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        $events = Event::all();

        // return view('events.index')->withTasks($events);
        return view('events.index', [
            'events' => Event::orderBy('created_at', 'asc')->get()
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
            'description' => 'required',
            'send_notification' => 'required',
        ]);

        $input = $request->all();
        $request->event_from_date = Carbon::now();
        $request->event_to_date = Carbon::now();

        Event::create(array(
            "name" => $request->name,
            "event_from_date" => Carbon::now(),
            "event_to_date" => Carbon::now(),
            "location" => $request->location,
            "description" => $request->description,
            "attachment" => $request->attachment,
            "status" => "draft",
            "send_notification" => $request->send_notification
            ));

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
        // $task = Task::findOrFail($id);

        // return view('tasks.show')->withTask($task);

        $event = Event::findOrFail($id);

        // return view('events.index')->withTasks($events);
        return view('events.view', [
            'event' => $event
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
        // $event = Event::findOrFail($id);

        return view('events.edit', [
            'events' => Event::orderBy('created_at', 'asc')->get(),
            'this_event' =>Event::findOrFail($id)
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

        // $task->fill($input)->save();
        $event->fill(array(
            "name" => $request->name,
            "event_from_date" => Carbon::now(),
            "event_to_date" => Carbon::now(),
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

}
