<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    /* ---------- Show & Create Views ---------- */

    public function show($id)
    {
        $property = Apartment::findOrFail($id);
        return view('property.show', compact('property'));
    }

    public function create()
    {
        return view('property.create');
    }

    /* ---------- Store (create new) ---------- */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'size'      => 'required|integer',
            'price'     => 'required|numeric',
            'street'    => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'age'       => 'required|integer',
            'rooms'     => 'required|integer',
            'bathrooms' => 'required|integer',
            'phone'     => 'required|string|max:20',
            'images'    => 'required|array',
            'images.*'  => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tour_zip'  => 'nullable|file|mimes:zip',
        ]);

        // Checkbox flags + seller
        $validated += [
            'elevator'                 => $request->has('elevator'),
            'balcony'                  => $request->has('balcony'),
            'parking'                  => $request->has('parking'),
            'private_garden'           => $request->has('private_garden'),
            'central_air_conditioning' => $request->has('central_air_conditioning'),
            'seller_id'                => auth()->id(),
        ];

        $apartment = Apartment::create($validated);

        /* — Store images — */
        foreach ($request->file('images') as $file) {
            $name = $file->getClientOriginalName();
            $file->storeAs('Images', $name, 'public');
            $apartment->images()->create(['image_url' => $name]);
        }

        /* — Optional virtual-tour ZIP — */
        if ($request->hasFile('tour_zip')) {
            $tmpPath  = $request->file('tour_zip')->store('tmp', 'local');
            $fullPath = Storage::disk('local')->path($tmpPath);

            $targetDir = public_path("tours/{$apartment->id}");
            File::ensureDirectoryExists($targetDir, 0755, true);

            $zip = new ZipArchive;
            if ($zip->open($fullPath) === true) {
                $zip->extractTo($targetDir);
                $zip->close();
            }

            Storage::disk('local')->delete($tmpPath);
            $apartment->update(['virtual_tour_path' => "tours/{$apartment->id}"]);
        }

        return redirect()
               ->route('property.show', $apartment->id)
               ->with('message', 'Property created successfully.');
    }

    /* ---------- Update (edit existing) ---------- */

    public function update(Request $request, $id)
    {
        $apartment = Apartment::findOrFail($id);

        $data = $request->validate([
            'size'      => 'required|integer',
            'price'     => 'required|numeric',
            'street'    => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'age'       => 'required|integer',
            'rooms'     => 'required|integer',
            'bathrooms' => 'required|integer',
            'phone'     => 'nullable|string|max:20',
            'images.*'  => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tour_zip'  => 'nullable|file|mimes:zip',
        ]);

        $data['elevator']                 = $request->has('elevator');
        $data['balcony']                  = $request->has('balcony');
        $data['parking']                  = $request->has('parking');
        $data['private_garden']           = $request->has('private_garden');
        $data['central_air_conditioning'] = $request->has('central_air_conditioning');

        $apartment->update($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = $file->getClientOriginalName();
                $file->storeAs('Images', $name, 'public');
                $apartment->images()->create(['image_url' => $name]);
            }
        }

        if ($request->hasFile('tour_zip')) {
            $oldDir = public_path("tours/{$apartment->id}");
            if (File::exists($oldDir)) {
                File::deleteDirectory($oldDir);
            }

            $tmpPath  = $request->file('tour_zip')->store('tmp', 'local');
            $fullPath = Storage::disk('local')->path($tmpPath);

            $targetDir = public_path("tours/{$apartment->id}");
            File::ensureDirectoryExists($targetDir, 0755, true);

            $zip = new ZipArchive;
            if ($zip->open($fullPath) === true) {
                $zip->extractTo($targetDir);
                $zip->close();
            }

            Storage::disk('local')->delete($tmpPath);
            $apartment->update(['virtual_tour_path' => "tours/{$apartment->id}"]);
        }

        return redirect()
               ->route('property.show', $apartment->id)
               ->with('message', 'Property updated successfully.');
    }

    /* ---------- Remove tour ---------- */

    public function removeTour($id)
    {
        $apartment = Apartment::findOrFail($id);
        $dir = public_path("tours/{$apartment->id}");
        if (File::exists($dir)) {
            File::deleteDirectory($dir);
        }
        $apartment->update(['virtual_tour_path' => null]);

        return redirect()
               ->route('seller.properties.edit', $apartment->id)
               ->with('message', 'Virtual tour removed.');
    }
}
