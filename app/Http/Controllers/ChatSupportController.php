<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatSupportController extends Controller
{
    public function index()
    {
        return view('admin.manage-chat-support');
    }
}
