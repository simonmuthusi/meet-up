@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Current Events
                </div>
               <div class="panel-body">
               	<h1>Add a New Event</h1>
				<hr>
				<!-- Display Validation Errors -->
                @include('common.errors')

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
				<a href="{{ route('events.index') }}">select</a>


               </div> 
            </div>
        </div>
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