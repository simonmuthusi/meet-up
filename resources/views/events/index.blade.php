@extends('home')
<style type="text/css">
    input[type="text"]{
        height: 35px !important;
    }
</style>

@section('view_event')
<div class="panel-body">
<!-- Current Events -->
@if (count($events) > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            Current Events
        </div>


        <div class="panel-body">
            <table class="table table-striped task-table">
                <thead>
                    <th>Event Name</th>
                    <th>Location</th>
                    <th>Date</th>
                </thead>
                <tbody>
                @if(!Session::has('view_getuserevents'))
                <tr><td colspan="4" class="text-warning">User signed events</td></tr>
                    @foreach ($events as $event)
                        <tr>
                            <td class="table-text"><div>{{ $event->name }} </div></td>
                            <td class="table-text"><div>{{ $event->location }}</div></td>
                            <td class="table-text"><div>{{ date('F d, Y H:i', strtotime($event->event_from_date)) }}</div></td>

                            <!-- Event Delete Button -->
                            @if (Auth::check())
                            @if ($event->user_id === Auth::user()->id )
                            <td>
                                <form action="{{ url('event/'.$event->id) }}" class="form-inline" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                            <a href="{{ route('events.edit', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-edit"></i>
                                </button>
                                </a>
                            </td>
                            @endif
                            <td>
                            <a href="{{ route('events.show', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-eye"></i>
                                </button>
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    @endif
                    @if(Session::has('view_userevents'))
                    <tr><td colspan="6" class="text-warning">User created events</td></tr>
                        @foreach ($created_events as $event)                        
                        <tr>
                            <td class="table-text"><div>{{ $event->name }} </div></td>
                            <td class="table-text"><div>{{ $event->location }}</div></td>
                            <td class="table-text"><div>{{ date('F d, Y H:i', strtotime($event->event_from_date)) }}</div></td>

                            <!-- Event Delete Button -->
                            @if (Auth::check())
                            @if ($event->user_id === Auth::user()->id )
                            <td>
                                <form action="{{ url('event/'.$event->id) }}" class="form-inline" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                            <a href="{{ route('events.edit', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-edit"></i>
                                </button>
                                </a>
                            </td>
                            @endif
                            <td>
                            <a href="{{ route('events.show', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-eye"></i>
                                </button>
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    @endif

                    @if(Session::has('view_getuserevents'))
                    <tr><td colspan="6" class="text-warning">Events for user {{$sel_user->email}}</td></tr>
                        @foreach ($created_events as $event)                        
                        <tr>
                            <td class="table-text"><div>{{ $event->name }} </div></td>
                            <td class="table-text"><div>{{ $event->location }}</div></td>
                            <td class="table-text"><div>{{ date('F d, Y H:i', strtotime($event->event_from_date)) }}</div></td>

                            <!-- Event Delete Button -->
                            @if (Auth::check())
                            @if ($event->user_id === $sel_user->id )
                            <td>
                                <form action="{{ url('event/'.$event->id) }}" class="form-inline" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                            <a href="{{ route('events.edit', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-edit"></i>
                                </button>
                                </a>
                            </td>
                            @endif
                            <td>
                            <a href="{{ route('events.show', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-eye"></i>
                                </button>
                                </a>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        </div>
@else
<div class="panel panel-default">
    <div class="panel-heading">
        Currently there are no events lined up
    </div>
</div>
@endif

</div>
@endsection

@section('add_event')
<div class="panel panel-default">
<div class="panel-heading">
    Add Event
</div>
<div class="panel-body">
<h1>Add a New Event</h1>
<hr>
<!-- Display Validation Errors -->
@include('common.errors')
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif

{!! Form::open([
    'route' => 'events.store'
]) !!}

<div class="form-group">
    {!! Form::label('name', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('event_from_date', 'Event From Date:', ['class' => 'control-label']) !!}
    <div id="datetimepicker" class="input-append date datepicker">
    {!! Form::text('event_from_date', null, ['class' => 'form-control datepicker']) !!}
    <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('event_to_date', 'Event To Date:', ['class' => 'control-label']) !!}
    <div id="datetimepicker" class="input-append date datepicker">
    {!! Form::text('event_to_date', null, ['class' => 'form-control datepicker', 'id' => 'datepicker']) !!}
    <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>

</div>
<div class="form-group">
    {!! Form::label('location', 'Location:', ['class' => 'control-label']) !!}
    {!! Form::text('location', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('status', 'Is Active:', ['class' => 'control-label']) !!}
    {!! Form::select('status', ['yes','no'], ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('send_notification', 'Receive Notification:', ['class' => 'control-label']) !!}
    {!! Form::select('send_notification', ['yes','no'], ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Create New Event', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

</div> 
</div>

   
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
     <script type="text/javascript"
     src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
    </script> 
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
    <script type="text/javascript">
      $('.datepicker').datetimepicker({
        format: 'yyyy-MM-dd hh:mm:ss',
        language: 'en'
      });
    </script>

  <script>
@endsection
