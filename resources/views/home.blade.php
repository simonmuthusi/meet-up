@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

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
                                        <th>Event</th>
                                        <th>&nbsp;</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($events as $event)
                                            <tr>
                                                <td class="table-text"><div>{{ $event->name }}</div></td>

                                                <!-- Event Delete Button -->
                                                <td>
                                                    <form action="{{ url('event/'.$event->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}

                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fa fa-btn fa-trash"></i>Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
        </div>
    </div>
</div>
@endsection

@section('user_menus')
@if (Auth::guest())
    <li><a href="{{ url('/login') }}">View Events</a></li>
@else
    <li><a href="{{ url('/login') }}">View Events</a></li>
@endif

@endsection
