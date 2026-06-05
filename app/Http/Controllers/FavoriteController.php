<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    
public function add(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id'
    ]);

    $user = $request->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    Favorite::firstOrCreate([
        'user_id' => $user->id,
        'course_id' => $request->course_id,
    ]);

    return response()->json(['success' => true]);
}
public function remove(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id'
    ]);

    $user = $request->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

    Favorite::where('user_id', $user->id)
        ->where('course_id', $request->course_id)
        ->delete();

    return response()->json([
        'success' => true,
        'message' => 'Removed from favorites'
    ]);
}
public function index()
{
    $user = request()->user();

    return response()->json([
        'favorites' => Favorite::with('course')
            ->where('user_id', $user->id)
            ->get()
    ]);
}

}