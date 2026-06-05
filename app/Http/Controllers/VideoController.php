<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;



class VideoController extends Controller
{
public function index(Request $request)
{
    $videos = Video::with('course');

    if ($request->filled('course_id')) {
        $videos->where('course_id', $request->course_id);
    }

    return $videos->get();
}
 public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'course_id' => 'required|exists:courses,id',
        'video' => 'required|file|mimes:mp4,mov,avi|max:51200',
    ]);

    $file = $request->file('video');

    // تخزين الفيديو
    $path = $file->store('videos', 'public');

    // حفظ بالداتابيس
    $video = Video::create([
        'title' => $request->title,
        'course_id' => $request->course_id,
        'video' => $path,
    ]);

    return response()->json([
        'message' => 'تم الرفع',
        'data' => $video
    ]);
}

    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $data = [
            'title' => $request->title,
            'course_id' => $request->course_id,
        ];

        // إذا تم رفع فيديو جديد
        if ($request->hasFile('video')) {
            $path = $request->file('video')
                             ->store('videos', 'public');

            $data['video'] = $path;
        }

        $video->update($data);

        return response()->json($video);
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}
