<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    // GET: /api/fee-structures
    public function index(Request $request)
    {
        $fees = FeeStructure::when($request->search, function ($q) use ($request) {
            $q->where('consultancy_name', 'like', '%' . $request->search . '%')
                ->orWhere('fee_type', 'like', '%' . $request->search . '%')
                ->orWhere('currency', 'like', '%' . $request->search . '%');
        })->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $fees
        ]);
    }

    // POST: /api/fee-structures
    public function store(Request $request)
    {
        $data = $request->validate([
            'consultancy_name' => 'required|string',
            'fee_type' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string'
        ]);

        $fee = new FeeStructure();
        $fee->consultancy_name = $data['consultancy_name'];
        $fee->fee_type = $data['fee_type'];
        $fee->amount = $data['amount'];
        $fee->currency = $data['currency'];
        $fee->save();

        return response()->json([
            'success' => true,
            'message' => 'Fee created successfully',
            'data' => $fee
        ], 201);
    }

    // GET: /api/fee-structures/{id}
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => FeeStructure::findOrFail($id)
        ]);
    }

    // PUT/PATCH: /api/fee-structures/{id}
    public function update(Request $request, $id)
    {
        $fee = FeeStructure::findOrFail($id);

        $data = $request->validate([
            'consultancy_name' => 'required|string',
            'fee_type' => 'required|string',
            'amount' => 'required|numeric',
            'currency' => 'required|string'
        ]);

        $fee->consultancy_name = $data['consultancy_name'];
        $fee->fee_type = $data['fee_type'];
        $fee->amount = $data['amount'];
        $fee->currency = $data['currency'];
        $fee->save();

        return response()->json([
            'success' => true,
            'message' => 'Fee updated successfully',
            'data' => $fee
        ]);
    }

    // DELETE: /api/fee-structures/{id}
    public function destroy($id)
    {
        FeeStructure::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fee deleted successfully'
        ]);
    }
}
