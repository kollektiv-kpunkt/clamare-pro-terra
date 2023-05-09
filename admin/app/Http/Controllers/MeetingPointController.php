<?php

namespace App\Http\Controllers;

use App\Models\MeetingPoint;
use App\Models\User;
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
     * Display Entries of the current user.
     */
    public function personal()
    {
        $meetingPoints = auth()->user()->meetingPoints()->paginate(10);
        return view('meeting_points.index', compact('meetingPoints'));
    }

    /**
     * Change Approval status of the Entry.
     */
    public function approval(MeetingPoint $meetingPoint)
    {
        $meetingPoint->update([
            'approved' => !$meetingPoint->approved
        ]);
        return back();
    }

    /**
     * API: Get all approved Entries.
     */
    public function apiGetMeetingpoints()
    {
        $meetingPoints = MeetingPoint::select("title", "description", "meeting_time", "location", "latitude", "longitude")->where('approved', true)->where("type", "meeting_point")->whereDate("meeting_time", ">", now())->get();
        return response()->json($meetingPoints);
    }

    /**
     * API: Get all approved Events.
     */
    public function apiGetEvents()
    {
        $meetingPoints = MeetingPoint::select("title", "description", "meeting_time", "location", "latitude", "longitude")->where('approved', true)->where("type", "event")->whereDate("meeting_time", ">", now())->get();
        return response()->json($meetingPoints);
    }

    /**
     * Userform: Create Event
     */
    public function store_frontend(Request $request)
    {
        $response = [
            "status" => "success",
            "message" => ""
        ];
        if (isset($request->user_email)) {
            $userExists = User::where('email', $request->user_email)->first();
            if (!$userExists) {
                $validated = $request->validate([
                    'user_email' => 'required|email|unique:users,email',
                ]);
                $user = new User();
                $user->name = $request->user_email;
                $user->email = $request->user_email;
                $user->role = 'user';
                $user->password = bcrypt(bin2hex(random_bytes(8)));
                $user->save();
                \Illuminate\Support\Facades\Password::sendResetLink($user->only('email'));
                $userId = $user->id;
                $response['message'] = __("We created a new User for you. Please check your email for password reset link.");
            } else {
                $userId = $userExists->id;
                $response['message'] = __("We assigned this entry to your existing account. <a href=\"/\" class=\"text-rose-500 underline\">You can login here and check your entries.</a>");
            }
        } else {
            $userId = 1;
            $response['message'] = __("We assigned this entry to the default user. If you wanna be able to edit it, please reach out to us.");
        }
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            "meeting_time" => 'required',
            "location" => 'required',
            "latitude" => 'required',
            "longitude" => 'required',
        ]);
        $validated['user_id'] = $userId;
        $meetingPoint = MeetingPoint::create($validated);
        $request->session()->flash('response', $response);
        return redirect()->route('create.success');
    }
}
