<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Session;
use App\Core\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth/login');
    }
    
    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (Auth::attempt($email, $password)) {
            Session::flash('success', 'Login realizado com sucesso!');
            $this->redirect('/dashboard');
        }
        
        Session::flash('error', 'Credenciais inválidas.');
        $this->redirect('/login');
    }
    
    public function showRegister(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth/register');
    }
    
    public function register(): void
    {
        $validator = new Validator();
        
        if (!$validator->validate($_POST, [
            'username' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ])) {
            Session::flash('errors', $validator->errors());
            $this->back();
            return;
        }
        
        User::register([
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role' => 'Operador'
        ]);
        
        Session::flash('success', 'Registro realizado com sucesso! Faça login.');
        $this->redirect('/login');
    }
    
    public function logout(): void
    {
        Auth::logout();
        Session::flash('success', 'Logout realizado com sucesso!');
        $this->redirect('/login');
    }
}
