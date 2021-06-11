<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index() : View
    {
        $users = User::where('is_admin', 0)->latest()->paginate(50);

        return view('admin.users.index', compact('users'));
    }
}
