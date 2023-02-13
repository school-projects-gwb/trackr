<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function overview()
    {
        $users = User::all();
        return view('admin.users.overview', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }
}
