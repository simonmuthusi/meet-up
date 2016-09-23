@extends('events.index')

@section('add_event')
<div class="panel panel-default">
<div class="panel-heading">
    Add Event
</div>
<div class="panel-body">
@if (Session::get('postpone'))
<h3>Editing Event Dates to Postpone "{{ $this_event->name }}"</h3>
@else
<h3>Editing Event "{{ $this_event->name }}"</h3>
@endif
<hr>

<!-- Display Validation Errors -->
@include('common.errors')
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif

{!! Form::model($this_event, [
    'method' => 'PATCH',
    'route' => ['events.update', $this_event->id]
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
@if(!Session::has('postpone'))
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
@endif

{!! Form::submit('Update Event', ['class' => 'btn btn-primary']) !!}

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