<?php

namespace App\Http\Controllers\API;

use App\Models\Lead;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LeadController extends Controller
{
        
    //List all leads (with optional filters)
    public function index(Request $request)
    {
        $query = Lead::with(['assignedUser', 'creator']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        return response()->json($query->get());
    }

    //Store a new lead
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $validated['created_by'] = Auth::id();

        $lead = Lead::create($validated);

        return response()->json(['message' => 'Lead created successfully', 'lead' => $lead], 201);
    }

    //Show a single lead
    public function show($id)
    {
        $lead = Lead::with(['assignedUser', 'creator'])->findOrFail($id);
        return response()->json($lead);
    }

    //Update a lead
    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $lead->update($validated);

        return response()->json(['message' => 'Lead updated successfully', 'lead' => $lead]);
    }

    //Delete a lead
    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return response()->json(['message' => 'Lead deleted successfully']);
    }

}
