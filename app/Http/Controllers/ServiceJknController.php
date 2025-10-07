<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceJknController extends Controller
{
    public function taskId3()
    {

        return response()->json(['message' => 'Task ID 3 executed successfully']);
    }
}
