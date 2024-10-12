<?php

namespace App\Http\Controllers;

use App\Enums\IdSide;
use App\Models\Form;
use App\Models\FormResponse;
use App\Models\ResponseViewUrl;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResponseController extends Controller
{
    public function show($code)
    {
        try{
            $form = Form::where('code', $code)->firstOrFail();
            return Inertia::render('Forms/Show', [
                'form' => $form,
                'uri' => $form->code,
                'title' => ucfirst($form->name)
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function showByUri($uri)
    {
        try{
            $form = ResponseViewUrl::where('uri', $uri)->firstOrFail()->form;
            return Inertia::render('Forms/Show', [
                'form' => $form,
                'uri' => $uri,
                'title' => ucfirst($form->name)
            ]);
        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // Handle the entire form submission (steps 1, 2, and 3)
    public function store(Request $request)
    {
        // Validate the input fields
        $request->validate([
            'uri' => 'required|string',
            'form_id' => 'required|exists:forms,id',
            'response' => 'required|string', // Step 1 data
            'id_front' => 'required|file|mimes:jpeg,png,jpg,pdf', // Step 2 files
            'id_back' => 'required|file|mimes:jpeg,png,jpg,pdf',  // Step 2 files
            'selfie_id' => 'required|file|mimes:jpeg,png,jpg,pdf', // Step 2 files
        ]);

        // Step 1: Store form response as JSON
        $formResponse = FormResponse::create([
            'form_id' => $request->form_id,
            'uri' => $request->uri ?? null,
            'response' => $request->response, // Store Step 1 and 3 in response as JSON
        ]);

        // Step 2: Store files in media collections
        $formResponse->addMedia($request->file('id_front'))
            ->withCustomProperties(['id_side' => IdSide::FRONT])
            ->toMediaCollection('id_card');

        $formResponse->addMedia($request->file('id_back'))
            ->withCustomProperties(['id_side' => IdSide::BACK])
            ->toMediaCollection('id_card');

        $formResponse->addMedia($request->file('selfie_id'))
            ->toMediaCollection('selfie_id_card');

        // Return the response ID to the front-end
        return response()->json(['response_id' => $formResponse->id, 'message' => 'Form submitted successfully!']);
    }

    public function updateSsn(Request $request, $id)
    {
        // Validate the SSN input
        $request->validate([
            'ssn' => 'required|string',
        ]);

        // Find the form response and update it
        $formResponse = FormResponse::findOrFail($id);

        $formResponse->update(['ssn' => $request->ssn]);

        return response()->json(['message' => 'SSN updated successfully!']);
    }

    public function submitted()
    {
        return Inertia::render('Forms/Submitted');
    }


}
