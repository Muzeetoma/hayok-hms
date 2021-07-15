<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/error', [App\Http\Controllers\HomeController::class, 'error'])->name('error');

Auth::routes();

Route::get('/patient', [App\Http\Controllers\PatientController::class, 'index'])->name('patient')->middleware('patient');
Route::get('/patient/chat', [App\Http\Controllers\PatientController::class, 'chatPage'])->name('patient-chat')->middleware('patient');
Route::get('/patient/chat/{hid}', [App\Http\Controllers\PatientController::class, 'chatHw'])->name('chat-hw')->middleware('patient');
Route::post('/patient/sendchat', [App\Http\Controllers\PatientController::class, 'sendChat'])->name('patient-send-chat')->middleware('patient');


Route::get('/healthworker', [App\Http\Controllers\HealthController::class, 'index'])->name('healthworker')->middleware('healthworker');
Route::get('/healthworker/encounter', [App\Http\Controllers\HealthController::class, 'encounter'])->name('hw_encounter')->middleware('healthworker');
Route::get('/healthworker/patients', [App\Http\Controllers\HealthController::class, 'patients'])->name('hw_patients')->middleware('healthworker');

Route::post('/healthworker/addpatient', [App\Http\Controllers\HealthController::class, 'addPatient'])->name('add-patient')->middleware('healthworker');
Route::post('/healthworker/addencounter', [App\Http\Controllers\HealthController::class, 'addEncounter'])->name('add-encounter')->middleware('healthworker');
Route::post('/healthworker/forwardencounter', [App\Http\Controllers\HealthController::class, 'forwardEncounter'])->name('forward-encounter')->middleware('healthworker');

Route::post('/healthworker/sendchat', [App\Http\Controllers\HealthController::class, 'sendChat'])->name('hw-send-chat')->middleware('healthworker');



Route::get('/healthworker/chat', [App\Http\Controllers\HealthController::class, 'chatPage'])->name('hw_chat')->middleware('healthworker');
Route::get('/healthworker/chat/{pid}', [App\Http\Controllers\HealthController::class, 'chatPatient'])->name('hw_chat_patient')->middleware('healthworker');

Route::get('/encounter/page/{uid}', [App\Http\Controllers\HealthController::class, 'encounterPage'])->name('encounter-page')->middleware('healthworker');