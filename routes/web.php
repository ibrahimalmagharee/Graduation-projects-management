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

Route::get('/contact_us', function () {
    $name='ali';
    return view('contactUs', compact('name'));
});

Route::post('/send', function (\Illuminate\Http\Request $request) {
    $name= $request->name;
    return view('contactUs', compact('name'));
})->name('send');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=> ['auth','admin']], function (){

    Route::get('/dashboard', function () {
        return view('Admin.pages.dashboard');
    });

    //Route Student

    Route::resource('/student', 'Admin\StudentController');
    Route::get('/view_student', 'Admin\StudentController@index')->name('view_student');
    Route::get('student/destroy/{id}', 'Admin\StudentController@destroy');


    //Route Teacher

    Route::resource('/teacher', 'Admin\TeacherController');
    Route::get('/view_teacher', 'Admin\TeacherController@index')->name('view_teacher');
    Route::get('teacher/destroy/{id}', 'Admin\TeacherController@destroy');

    //Route Project

    Route::resource('/project', 'Admin\ProjectController');
    Route::get('/view_project', 'Admin\ProjectController@index')->name('view_project');
    Route::get('project/destroy/{id}', 'Admin\ProjectController@destroy');

    //Route Advertise

    Route::resource('/advertise', 'Admin\AdvertiseController');
    Route::get('/view_advertise', 'Admin\AdvertiseController@index')->name('view_advertise');
    Route::get('advertise/destroy/{id}', 'Admin\AdvertiseController@destroy');

    //Route Group

    Route::resource('/group', 'Admin\GroupController');
    Route::get('/view_group', 'Admin\GroupController@index')->name('view_group');
    Route::get('group/destroy/{id}', 'Admin\GroupController@destroy');

    //Route Discussion

    Route::resource('/discussion', 'Admin\DiscussionController');
    Route::get('/view_discussion', 'Admin\DiscussionController@index')->name('view_discussion');
    Route::get('discussion/destroy/{id}', 'Admin\DiscussionController@destroy');

});
