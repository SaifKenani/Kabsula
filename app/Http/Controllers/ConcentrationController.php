<?php

namespace App\Http\Controllers;

use App\Models\Concentration;
use Illuminate\Http\Request;

class ConcentrationController extends Controller
{
    public function index()
    {
        $concentrations = Concentration::all();

        return response()->json([
            'concentrations' => $concentrations
        ]);
    }

    public function show($id)
    {
        $concentration = Concentration::findOrFail($id);

        return response()->json([
            'concentration' => $concentration
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|integer',
            'unit' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $concentration = new Concentration();
        $concentration->value = $request->value;
        $concentration->unit = $request->unit;
        $concentration->description = $request->description;

        $concentration->save();

        return response()->json([
            'message' => 'Concentration created successfully!',
            'concentration' => $concentration
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $concentration = Concentration::findOrFail($id);

        $request->validate([
            'value' => 'sometimes|integer',
            'unit' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->has('value')) {
            $concentration->value = $request->value;
        }

        if ($request->has('unit')) {
            $concentration->unit = $request->unit;
        }

        if ($request->has('description')) {
            $concentration->description = $request->description;
        }

        $concentration->save();

        return response()->json([
            'message' => 'Concentration updated successfully!',
            'concentration' => $concentration
        ]);
    }

    public function destroy($id)
    {
        $concentration = Concentration::findOrFail($id);
        $concentration->delete();

        return response()->json([
            'message' => 'Concentration deleted successfully!'
        ]);
    }
}
