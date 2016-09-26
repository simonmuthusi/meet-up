@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div id="left-panel" class="col-md-7 col-md-offset-0">
                @yield('view_event')
        </div>

        <div id="right-panel" class="col-md-4 col-md-offset-0">
        @yield('add_event')
        @yield('edit_event')
        </div>

    </div>
</div>
@endsection

@section('user_menus')
@if (Auth::guest())
@else
    <li><a href="{{ url('/user/events') }}">View My Events</a></li>
@endif

@endsection
