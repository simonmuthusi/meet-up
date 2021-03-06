@extends('home')

@section('view_event')
<div class="panel-body">
    <div class="panel panel-default">
        <div class="panel-heading">
            Event Details {{ $event->name }}
        </div>
        <div class="panel-body">
           <div class="form-inline">
                <label>Name</label>
                <div>{{ $event->name }}</div>
            </div>
            <div class="form-inline">
                <label>From Date</label>
                <div>{{ $event->event_from_date }}</div>
            </div>
            <div class="form-inline">
                <label>To Date</label>
                <div>{{ $event->event_to_date }}</div>
            </div>
            <div class="form-inline">
                <label>Locatiom</label>
                <div>{{ $event->location }}</div>
            </div>
            <div class="form-inline">
                <label>Description</label>
                <div>{{ $event->description }}</div>
            </div>
            <div class="form-inline">
                <label>Attachement</label>
                <div>{{ $event->attchment }}</div>
            </div>
            <div class="form-inline">
                <label>Status</label>
                <div>{{ $event->status }}</div>
            </div>
            <div class="form-inline">
                <label>Receive Notifications ?</label>
                <div>{{ $event_notification }}</div>
            </div>
            @if (Auth::check())
            @if ($event->user_id === Auth::user()->id )
            <div class="form-inline">
                <label>Is Active</label>
                <div>{{ $event_is_active }}</div>
            </div>
            @endif
            @endif
        </div>
        </div>

</div>
@endsection



@section('add_event')
@if (Auth::check())
<div class="panel panel-default">
<div class="panel-heading">
    Right Pannel
</div>
<div class="panel-body">
<div class="panel panel-default">
<div class="panel-heading">
Users Attending
</div>
<div class="panel-body">
<ul>
    @if (count($event->users) > 0)
        @foreach ($event->users as $user)
            <li><a title="view user events" href="{{ route('events.getuserevents', $user->id) }}">{{ $user->email }}</a></li>
        @endforeach
    @else
        No users signed for event !
    @endif
</ul>
</div>
</div>
</div>

<div class="panel-body">
<div class="panel panel-default">
<div class="panel-heading">
Manage Event
</div>
<div class="panel-body">
<ul>
    @if ($event->user_id === Auth::user()->id )
    @if ($event->is_active)
    <li><a href="{{ route('events.activateevent', $event->id) }}">Cancel Event</a></li>
    @else
    <li><a href="{{ route('events.activateevent', $event->id) }}">Activate Event</a></li>
    @endif

    <li><a href="{{ route('events.postponeevents', $event->id) }}">Postpone Event</a></li>
    <li><a href="{{ route('events.messageparticipants', $event->id) }}">Message Participants</a></li>
    @endif

    @if ($is_registered)
    <li><a href="{{ route('events.user_register', $event->id) }}">De-register</a></li>
    @elseif ($event->user_id === Auth::user()->id )
    @else
    <li><a href="{{ route('events.user_register', $event->id) }}">Register</a></li>
    @endif

    <li><a href="{{ route('events.userevents') }}">View All my Events</a></li> 
</ul>
</div>
</div>
</div>

</div>
<hr>

@else
<div class="panel panel-default">
<div class="panel-heading">
    Login for more options here
</div>
</div>
@endif
@endsection