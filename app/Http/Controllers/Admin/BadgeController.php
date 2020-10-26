<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Badge;
use Illuminate\Database\Eloquent\Collection;
use App\Activity;

class BadgeController extends Controller
{

    public function index()
    {
        $badges = Badge::with('course')->get();
        return view('admin.course.badge.index', compact('badges'));
    }

    public function edit($badge)
    {
    	$badge = Badge::with('course')->find($badge);
        return view('admin.course.badge.edit', compact('badge', 'criterias'));
    }
}
