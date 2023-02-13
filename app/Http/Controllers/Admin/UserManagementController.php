<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function overview()
    {
        return view('admin.users.overview');
    }
}
