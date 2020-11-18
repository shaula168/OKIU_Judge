<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teachers-guide', function () {
    return view('welcome_t');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ログイン状態
Route::group(['middleware' => 'auth'], function() {

    Route::get('classrooms/join', 'ClassroomsController@join_classroom');
    Route::post('classrooms/register', 'ClassroomsController@register_classroom');
    Route::resource('classrooms', 'ClassroomsController',
        ['only' => ['create', 'store', 'show', 'edit', 'update']]);
    
    Route::get('classrooms/{class_id}/create-task', 'TasksController@create');
    Route::get('classrooms/{class_id}/tasks/{task_id}', 'TasksController@show');
    Route::get('classrooms/{class_id}/tasks/{task_id}/edit', 'TasksController@edit');
    Route::get('classrooms/{class_id}/tasks/{task_id}/issues', 'TasksController@issues');
    Route::get('classrooms/{class_id}/tasks/{task_id}/submissions', 'TasksController@submissions');
    Route::get('classrooms/{class_id}/tasks/{task_id}/submission/{submit_id}', 'TasksController@show_submit');
    Route::get('classrooms/{class_id}/tasks/{task_id}/answer', 'TasksController@answer');
    Route::get('classrooms/{class_id}/tasks/{task_id}/standings', 'TasksController@standings');
    Route::get('classrooms/{class_id}/tasks/{task_id}/status-lists', 'TasksController@status_lists');
    Route::post('classrooms/{class_id}/tasks/{task_id}/post-issue', 'TasksController@post_issue');
    Route::post('classrooms/{class_id}/tasks/{task_id}/submit', 'TasksController@submit');
    Route::resource('tasks', 'TasksController',
        ['only' => ['store', 'update']]);

});