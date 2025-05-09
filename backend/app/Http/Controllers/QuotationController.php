<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Client;
use Barryvdh\DomPDF\Facade as PDF;

class QuotationController extends Controller
{
  public function create()
    {
        $clients = Client::all(); // Fetch clients for the dropdown
        return view('quotations.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'clientId' => 'required|exists:clients,id',
        'items' => 'required|array',
        'items.*.name' => 'required|string',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.unitPrice' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
        'subtotal' => 'required|numeric|min:0',
        'tax' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'createdBy' => 'required|exists:users,id',
    ]);

    $quotation = Quotation::create($validated);

    return response()->json($quotation, 201);
    
    }

    public function downloadPdf($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        $pdf = PDF::loadView('quotations.pdf', compact('quotation'));
        return $pdf->download('quotation-' . $quotation->quotation_number . '.pdf');
    }  
}
