<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\YearLevel;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function loadBilling()
    {
        $allYearLevels = YearLevel::paginate();
        $allBillings = Billing::paginate();
        return view('admin.manage-billing', [
            'allYearLevels' => $allYearLevels,
            'allBillings' => $allBillings
        ]);
    }

    public function storeBilling(Request $request)
    {
        $request->validate([
            'yearLevelId' => 'required|exists:year_levels,yearLevelId',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        Billing::create($request->only('yearLevelId', 'description', 'amount'));

        session()->flash('success', 'New billing added successfully!');
        return redirect()->route('manageBilling');
    }

    public function updateBilling(Request $request)
    {
        $billing = Billing::findOrFail($request->billingId);
        $billing->update($request->only('description', 'amount'));
        session()->flash('success', 'The billing was successfully updated.');
        return redirect()->route('manageBilling');
    }

    public function destroyBilling($id)
    {
        Billing::findOrFail($id)->delete();
        session()->flash('info', 'The billing was deleted and cannot be recovered.');
        return redirect()->route('manageBilling');
    }
}
