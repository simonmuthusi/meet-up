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
    @if(Session::has('postpone'))
    <input type="hidden" name="action_type" id="action_type" value="postpone">
    @else
    <input type="hidden" name="action_type" id="action_type" value="edit">
    @endif
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
    {!! Form::label('send_notification', 'Receive Notification:', ['class' => 'control-label']) !!}
    <select id="send_notification" name="send_notification" class="form-cotrol">
    @foreach ($send_notification as $not)
    @if ($not==$event_not)
    <option value="{{$not}}" selected>{{ $not }}</option>
    @else
    <option value="{{$not}}">{{ $not }}</option>
    @endif
    @endforeach      
    </select>
</div>
@endif

{!! Form::submit('Update Event', ['class' => 'btn btn-primary']) !!}

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

@endsection