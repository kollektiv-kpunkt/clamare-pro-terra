<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Return Image of Snapshot from Testimonial Resource
     */
    public function index(string $image)
    {
        $id = pathinfo($image)['filename'];
        $testimonialPath = public_path('uploads/images/testimonials/' . $id . '.png');
        try {
            $testimonial = Browsershot::url($_ENV["APP_URL"] . "/api/testimonial/display/" . $image)
                ->ignoreHttpsErrors()
                ->setNodeBinary('/usr/bin/node')
                ->setNpmBinary('/usr/bin/npm')
                ->windowSize(1920, 1920)
                ->noSandbox()
                ->waitUntilNetworkIdle()
                ->save($testimonialPath);
            $testimonialName = $id . '.png';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        // Storage::disk('public_uploads')->delete('images/i/' . $image);
        return response()->download($testimonialPath, $testimonialName)->deleteFileAfterSend(true);
    }

    /**
     * Display Testimonial Template
     */
    public function display(string $image)
    {
        return view('testimonials.dispaly', ['image' => $image]);
    }

    /**
     * Upload Testimonial Image
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $id = Str::uuid()->toString();
        $imageName = $id . '.' . $request->image->extension();
        Storage::disk('public_uploads')->putFileAs('images/i/', $request->file('image'), $imageName);
        return redirect()->route('testimonial.index', ['image' => $imageName]);
    }
}
