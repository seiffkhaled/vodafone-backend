<?php

namespace App\Http\Controllers\Web\User\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function userTasks()
    {
        $tasks = ['task1', 'task2', 'task3'];
        return view('task', compact('tasks'));
    }
}
