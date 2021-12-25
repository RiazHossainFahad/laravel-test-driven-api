<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

Route::apiResource('todo-lists', TodoListController::class);