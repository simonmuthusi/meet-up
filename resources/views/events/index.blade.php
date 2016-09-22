@extends('home')

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
                    @foreach ($events as $event)
                        <tr>
                            <td class="table-text"><div>{{ $event->name }}</div></td>
                            <td class="table-text"><div>{{ $event->location }}</div></td>
                            <td class="table-text"><div>{{ $event->event_from_date }}</div></td>

                            <!-- Event Delete Button -->
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
                            <td>
                            <a href="{{ route('events.show', $event->id) }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-btn fa-eye"></i>
                                </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    {!! Form::text('event_from_date', null, ['class' => 'form-control datepicker']) !!}
</div>
<div class="form-group">
    {!! Form::label('event_to_date', 'Event To Date:', ['class' => 'control-label']) !!}
    {!! Form::text('event_to_date', null, ['class' => 'form-control datepicker', 'id' => 'datepicker']) !!}
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
    {!! Form::label('attachment', 'Attachment:', ['class' => 'control-label']) !!}
    {!! Form::file('attachment', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('status', 'Status:', ['class' => 'control-label']) !!}
    {!! Form::select('status', ['draft','not attending','attending'], ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('send_notification', 'Receive Notification:', ['class' => 'control-label']) !!}
    {!! Form::select('send_notification', ['yes','no'], ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Create New Event', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

</div> 
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>  
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <link rel="stylesheet" href="http://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.css">
  <script src="http://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js"></script>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
  </script>

@endsection
