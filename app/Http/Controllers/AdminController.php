<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\FeeReceipt;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function pendingReceipts()
    {
        $pendingReceipts = FeeReceipt::where('status', 'pending')->get();
        return view('admin.fee_receipts.pending', compact('pendingReceipts'));
    }

    public function approveReceipt($id)
    {
        $feeReceipt = FeeReceipt::findOrFail($id);
        $feeReceipt->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Fee receipt approved successfully.');
    }

    public function rejectReceipt($id)
    {
        $feeReceipt = FeeReceipt::findOrFail($id);
        $feeReceipt->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Fee receipt rejected.');
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminModel $adminModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminModel $adminModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminModel $adminModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminModel $adminModel)
    {
        //
    }
}
