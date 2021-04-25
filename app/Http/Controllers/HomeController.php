<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $user=User::create([
//            'name' => 'Nurullah Demirel',
//            'email' => 'i@gmail.com',
//            'email_verified_at' => now(),
//            'password' => bcrypt('password'), // password
//            'remember_token' => Str::random(10),
//        ]);
//        $role=Role::create(['name'=>'Admin']);
//        Permission::create(['name'=>'see user todo']);
//        $user->givePermissionTo('see user todo');
//        $role->givePermissionTo('see user todo');

        return view('home');
    }
    public function users(){
        return view('users');
    }

}
