<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Counselor;
use App\Models\University;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => Student::count(),
            'active_courses' => Course::where('status', true)->count(),
            'total_counselors' => Counselor::count(),
            'total_universities' => University::count(),
            'top_universities' => University::orderBy('created_at', 'desc')->paginate(5),
        ];

        return response()->json($stats);
    }
}
