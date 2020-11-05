<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\StudentActivityLog;
use Illuminate\Http\Request;

class StudentActivityLogController extends Controller
{
    public function show($id)
    {
    	return StudentActivityLog::where('user_id', $id)->get();
    }
}
