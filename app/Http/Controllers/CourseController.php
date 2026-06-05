<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;



class CourseController extends Controller
{
    public function index()
    {
          return response()->json([
            'status' => true,
            'course' => Course::all()
     ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courses',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course = Course::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return response()->json($course);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);

        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}