<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FileUploader;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_data['badges'] = Badge::latest()->get();
        $page_data['page_title'] = 'Badge Management';
        return view('admin.badges.index', $page_data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_data['page_title'] = 'Create New Badge';
        return view('admin.badges.create', $page_data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,svg|max:2048',
            'rule_type' => 'required|string',
            'rule_value' => 'required|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/badges/' . $imageName;
            FileUploader::upload($file, $path);
            $imagePath = $path;
        }

        Badge::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $imagePath,
            'rule_type' => $request->rule_type,
            'rule_value' => $request->rule_value,
        ]);

        return redirect()->route('badges.index')->with('success', 'Badge created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Badge $badge)
    {
        // Not typically needed for admin management, redirect to edit.
        return redirect()->route('badges.edit', $badge);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Badge $badge)
    {
        $page_data['badge'] = $badge;
        $page_data['page_title'] = 'Edit Badge';
        return view('admin.badges.edit', $page_data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Badge $badge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,svg|max:2048', // Image is optional on update
            'rule_type' => 'required|string',
            'rule_value' => 'required|string',
        ]);

        $data = $request->only(['name', 'description', 'rule_type', 'rule_value']);

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($badge->image_path && file_exists(public_path($badge->image_path))) {
                unlink(public_path($badge->image_path));
            }

            // Upload the new image
            $file = $request->file('image');
            $imageName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/badges/' . $imageName;
            FileUploader::upload($file, $path);
            $data['image_path'] = $path;
        }

        $badge->update($data);

        return redirect()->route('badges.index')->with('success', 'Badge updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        // Delete the image file if it exists
        if ($badge->image_path && file_exists(public_path($badge->image_path))) {
            unlink(public_path($badge->image_path));
        }
        $badge->delete();
        return redirect()->route('badges.index')->with('success', 'Badge deleted successfully.');
    }

    /**
     * Show the public sharing page for an awarded badge.
     */
    public function share(UserBadge $id)
    {
        $userBadge = $id; // Route model binding
        $page_data['userBadge'] = $userBadge;
        return view('frontend.default.badges.share', $page_data);
    }
}
