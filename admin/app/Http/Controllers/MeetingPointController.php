<?php

namespace App\Http\Controllers;

use App\Models\MeetingPoint;
use Illuminate\Http\Request;

class MeetingPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meetingPoints = MeetingPoint::paginate(10);
        return view('meeting_points.index', compact('meetingPoints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meeting_points.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            "meeting_time" => 'required',
            "location" => 'required',
            "latitude" => 'required',
            "longitude" => 'required',
        ]);
        $validated['user_id'] = auth()->user()->id;
        MeetingPoint::create($validated);
        return redirect()->route('meeting_points.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(MeetingPoint $meetingPoint)
    {
        return view('meeting_points.show', compact('meetingPoint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeetingPoint $meetingPoint)
    {
        return view('meeting_points.edit', compact('meetingPoint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeetingPoint $meetingPoint)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            "meeting_time" => 'required',
            "location" => 'required',
            "latitude" => 'required',
            "longitude" => 'required',
        ]);
        $meetingPoint->update($validated);
        return redirect()->route('meeting_points.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeetingPoint $meetingPoint)
    {
        $meetingPoint->delete();
        return back();
    }

    /**
     * Display Meeting points of the current user.
     */
    public function personal()
    {
        $meetingPoints = auth()->user()->meetingPoints()->paginate(10);
        return view('meeting_points.index', compact('meetingPoints'));
    }

    /**
     * Change Approval status of the Meeting Point.
     */
    public function approval(MeetingPoint $meetingPoint)
    {
        $meetingPoint->update([
            'approved' => !$meetingPoint->approved
        ]);
        return back();
    }

    /**
     * API: Get all approved Meeting Points.
     */
    public function apiGet()
    {
        $meetingPoints = MeetingPoint::select("title", "description", "meeting_time", "location", "latitude", "longitude")->where('approved', true)->get();
        return response()->json($meetingPoints);
    }
}
