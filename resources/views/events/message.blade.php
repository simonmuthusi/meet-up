@extends('events.view')

@section('view_event')
<div class="panel-body">
    <div class="panel panel-default">
        <div class="panel-heading">
            Message Participants for event "{{ $event->name }}""
        </div>
        <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')
        @if(Session::has('mail_message'))
            <div class="alert alert-success">
                {{ Session::get('mail_message') }}
            </div>
        @endif

        {!! Form::model($event, [
            'method' => 'PATCH',
            'route' => ['events.emailparticipants', $event->id]
        ]) !!}

        <div class="form-group">
            {!! Form::label('message', 'Message:', ['class' => 'control-label']) !!}
            {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
        </div>

        {!! Form::submit('Send Message', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}
        </div>
        </div>

</div>
@endsection

