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
Auth::routes();//Authentication routes, predefined by Laravel

Route::get('/', 'QuizController@Home');//Returns the home page

Route::get('/aboutus', function(){//Returns the about us page
    return view('about');
});

Route::get('/panel', 'QuizController@RedirectToAppropriatePanel');//Redirect to appropriate panel

Route::resource('quiz', 'QuizEventController', ['only' => [//Quiz Events
    'create', 'store', 'show', 'update'
]]); 

Route::get('/assignment/{id}', 'QuizEventController@assignment_show');
Route::get('create/assignment', 'QuizEventController@assignment_create_form');
Route::post('/post/assignment', 'QuizEventController@assignment_post');

Route::resource('take', 'TakeQuizController', ['only' => [//Related to taking of quiz
    'store', 'show'
]]); 

Route::get('/assignment/take/{id}', 'TakeQuizController@assignment_show');
Route::post('/submit/assignment', 'TakeQuizController@assignment_submit');

Route::resource('class', 'ClassController',  ['only' => [//Class
    'store', 'show', 'destroy'
]]);

Route::resource('question', 'QuestionController', ['only' => [//Question
    'store', 'update',  'destroy',
]]); 

Route::resource('subjects', 'SubjectController', ['only' => [//Subject
    'index', 'store', 'update', 'destroy'
]]);

Route::resource('teachers', 'TeacherController', ['only' => [//Teacher list
    'index'
]]);

Route::resource('account', 'AccountController', ['only' => [//Account management
    'store', 'update', 'destroy'
]]);

Route::resource('questionnaire', 'QuestionnaireController', ['only' => [//Questionnaire
    'show', 
]]);

Route::post('join', 'QuizController@JoinClass');

// Route::post('/test', function (){//Debugging purposes only
//     return $_POST;
// });
