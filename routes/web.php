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

Route::get('/', function () {
    return view('home', [
        'events' => Event::orderBy('created_at', 'asc')->get()
    ]);
});


/**
 * Delete Event
 * Only aunthenticated owners of events are able to delete an event
 */
Route::delete('/event/{id}', function ($id) {
    Task::findOrFail($id)->delete();

    return redirect('/');
})->middleware('auth');;


Auth::routes();

Route::get('/home', 'HomeController@index');
