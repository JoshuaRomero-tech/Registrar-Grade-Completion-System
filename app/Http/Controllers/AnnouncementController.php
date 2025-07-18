<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Announcement;
use App\Models\Course;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->with('user')->get();
        return view('announcement.index', compact('announcements'));
    }

    public function create()
    {
        if (!in_array(Auth::user()->role, ['dean', 'faculty'])) {
            abort(403);
        }
        $courses = Course::all();
        return view('announcement.create', compact('courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!in_array(Auth::user()->role, ['dean', 'faculty'])) {
            abort(403);
        }
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        \Log::info('Creating announcement', [
            'user_id' => Auth::id(),
            'course_id' => $validated['course_id'],
        ]);
        Announcement::create([
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'body' => $validated['body'],
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('announcement.index')->with('success', 'Announcement created!');
    }
} 