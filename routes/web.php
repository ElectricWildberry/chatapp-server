<?php

use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\UserController;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/user')->controller(UserController::class)->name('user.')->group(function (){
    Route::get('/login', 'login')->name('login');
    Route::get('/create', 'create')->name('create');
});

Route::get('/get/{id}', function ($id) {
    return User::where('id', $id)->get()->first()->toResource();
});

Route::get('/getuser/{id}/profile', function (string $id) {
    return UserProfile::where('user_id', $id)->get()->first()->toResource();
});

Route::prefix('chat')->controller(ChatMessageController::class)->name('chat.')->group(function (){
    Route::get('/send', 'send')->name('send');
    Route::get('/edit', 'edit')->name('edit');
    Route::get('/getbyroom', 'get')->name('get');
    Route::get('/newbyroom', 'new')->name('new');
});

Route::get('/getchatbyuser/{id}', function (string $id) {
    return ChatMessageResource::collection(ChatMessage::where('sender_user_id', $id)->get());
});