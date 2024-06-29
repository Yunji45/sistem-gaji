<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as user;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profil';
        $user = Auth::user();
        $role = $user -> getRoleNames()->first();
        // return $role;
        return view ('Auth.profil',compact('title','user','role'));
    }
}
