<?php

use App\Event;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * View All Events
 * All can view events
 */
Route::get('/',[
    'as' => 'events.index',
    'uses' => 'EventController@index'
]);

/**
 * Delete Event
 * Only aunthenticated owners of events are able to delete an event
 */
Route::delete('/event/{id}', function ($id) {
    Event::findOrFail($id)->delete();

    return redirect('/');
})->middleware('auth');


Auth::routes();

Route::get('/home', 'EventController@index');
// Route::get('/events/index', 'EventController@index');
// Route::get('/events/show/{id}', 'EventController@show');
Route::resource('events', 'EventController');

Route::get('/user/events/{id}',[
    'as' => 'events.userevents',
    'uses' => 'EventController@userevents'
]);

Route::get('/event/postpone/{id}',[
    'as' => 'events.postponeevents',
    'uses' => 'EventController@postpone'
]);

Route::get('/event/activate/{id}',[
    'as' => 'events.activateevent',
    'uses' => 'EventController@activate'
]);

Route::get('/event/message/{id}',[
    'as' => 'events.messageparticipants',
    'uses' => 'EventController@message'
]);

Route::patch('/event/email/{id}',[
    'as' => 'events.emailparticipants',
    'uses' => 'EventController@emailparticipants'
]);

Route::get('/user/register/event/{id}',[
    'as' => 'events.user_register',
    'uses' => 'EventController@user_register'
]);