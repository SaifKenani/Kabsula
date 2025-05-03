<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{

    public function index()
    {
        $forms = Form::all();

        return response()->json([
            'forms' => $forms
        ]);
    }

    public function show($id)
    {
        $form = Form::findOrFail($id); //  Form::where('id', $id)->firstOrFail();

        return response()->json([
            'form' => $form
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $form = new Form();
        $form->name = $request->name;
        $form->description = $request->description;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('forms', 'public');
            $form->image = $path;
        }

        $form->save();

        return response()->json([
            'message' => 'Form created successfully!',
            'form' => $form
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('name')) {
            $form->name = $request->name;
        }

        if ($request->has('description')) {
            $form->description = $request->description;
        }

        if ($request->hasFile('image')) {
            if ($form->image && Storage::disk('public')->exists($form->image)) {
                Storage::disk('public')->delete($form->image);
            }

            $path = $request->file('image')->store('forms', 'public');
            $form->image = $path;
        }

        $form->save();

        return response()->json(['message' => 'Form updated successfully', 'form' => $form]);
    }

    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        if ($form->image && Storage::disk('public')->exists($form->image)) {
            Storage::disk('public')->delete($form->image);
        }
        $form->delete();

        return response()->json(['message' => 'Form deleted successfully']);
    }

}
