<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $this->requireRole('Admin');
        
        $users = User::all();
        
        $this->view('users/index', ['users' => $users]);
    }
}
