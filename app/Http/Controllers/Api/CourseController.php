<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // GET: /api/courses
    public function index(Request $request)
    {
        $courses = Course::when($request->search, function ($q) use ($request) {
            $q->where('course_name', 'like', '%' . $request->search . '%')
                ->orWhere('field', 'like', '%' . $request->search . '%')
                ->orWhere('country', 'like', '%' . $request->search . '%');
        })->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    // POST: /api/courses
    public function store(Request $request)
    {
        $request->validate([
            'course_name'  => 'required|string',
            'level'        => 'required|string',
            'field'        => 'required|string',
            'duration'     => 'required|string',
            'intake'       => 'required|string',
            'country'      => 'required|string',
            'university'   => 'required|string',
            'tuition_fee'  => 'required|numeric',
            'status'       => 'required|boolean'
        ]);

        $course = new Course();
        $course->course_name = $request->course_name;
        $course->level       = $request->level;
        $course->field       = $request->field;
        $course->duration    = $request->duration;
        $course->intake      = $request->intake;
        $course->country     = $request->country;
        $course->university  = $request->university;
        $course->tuition_fee = $request->tuition_fee;
        $course->status      = $request->status;
        $course->save();

        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }

    // GET: /api/courses/{id}
    public function show($id)
    {
        $course = Course::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $course
        ]);
    }

    // PUT: /api/courses/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_name'  => 'required|string',
            'level'        => 'required|string',
            'field'        => 'required|string',
            'duration'     => 'required|string',
            'intake'       => 'required|string',
            'country'      => 'required|string',
            'university'   => 'required|string',
            'tuition_fee'  => 'required|numeric',
            'status'       => 'required|boolean'
        ]);

        $course = Course::findOrFail($id);
        $course->course_name = $request->course_name;
        $course->level       = $request->level;
        $course->field       = $request->field;
        $course->duration    = $request->duration;
        $course->intake      = $request->intake;
        $course->country     = $request->country;
        $course->university  = $request->university;
        $course->tuition_fee = $request->tuition_fee;
        $course->status      = $request->status;
        $course->save();

        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ]);
    }

    // DELETE: /api/courses/{id}
    public function destroy($id)
    {
        Course::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully'
        ]);
    }

    // PATCH: /api/courses/{id}/status
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $course = Course::findOrFail($id);
        $course->status = $request->status;
        $course->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $course
        ]);
    }
}
