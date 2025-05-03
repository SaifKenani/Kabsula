<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    public function index()
    {
        return response()->json(['manufactures' => Manufacturer::all()]);
    }

    public function show($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        return response()->json(['manufacturer' => $manufacturer]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        $manufacturer = Manufacturer::create([
            'name' => $request->name,
            'country' => $request->country,
            'website' => $request->website,
        ]);

        return response()->json([
            'message' => 'Manufacturer created successfully',
            'manufacturer' => $manufacturer
        ]);
    }

    public function update(Request $request, $id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'country' => 'nullable|string',
            'website' => 'nullable|url',
        ]);

        if ($request->has('name')) {
            $manufacturer->name = $request->name;
        }

        if ($request->has('country')) {
            $manufacturer->country = $request->country;
        }

        if ($request->has('website')) {
            $manufacturer->website = $request->website;
        }

        $manufacturer->save();

        return response()->json([
            'message' => 'Manufacturer updated successfully',
            'manufacturer' => $manufacturer
        ]);
    }

    public function destroy($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->delete();

        return response()->json(['message' => 'Manufacturer deleted successfully']);
    }
}
