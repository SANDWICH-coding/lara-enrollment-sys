<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loadAllSchoolYear()
    {
        $allSchoolYears = SchoolYear::paginate();
        return view('admin.manage-school-year', [
            'allSchoolYears' => $allSchoolYears
        ]);
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
    public function storeSchoolYear(Request $request)
    {

        $isActive = $request->input('isActive', 2);

        // Validate input data
        $validator = Validator::make($request->all(), [
            'schoolYearName' => [
                'required',
                'regex:/^\d{4}-\d{4}$/', // Enforces the format YYYY-YYYY
            ],
            'isActive' => 'integer|in:1,2',
        ]);


        // Check validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // Check if there's already an active school year
        $existingActiveSchoolYear = SchoolYear::where('isActive', 1)->exists();

        if ($isActive == 1 && $existingActiveSchoolYear) {
            return response()->json([
                'success' => false,
                'errors' => ['isActive' => ['There is already an active school year.']],
            ]);
        }

        // Check if there's already schoolyearName exists
        $existingSchoolYearName = SchoolYear::where('schoolYearName', $request->input('schoolYearName'))->exists();

        if ($existingSchoolYearName) {
            return response()->json([
                'success' => false,
                'errors' => ['schoolYearName' => ['School year name already exists.']],
            ]);
        }


        // Prepare data for creation
        $schoolYearData = $request->only(['schoolYearName', 'isActive']);

        // Create school year
        $schoolYear = SchoolYear::create($schoolYearData);

        // Set success message
        session()->flash('success', 'School year created successfully.');

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'School year created successfully.',
            'data' => $schoolYear,
        ]);
    }

    // SchoolYearController.php
    public function toggleStatus(Request $request, $id)
    {
        $schoolYear = SchoolYear::findOrFail($id);

        // Check if there's already an active school year when activating another one
        if ($request->isActive == 1) {
            $existingActiveSchoolYear = SchoolYear::where('isActive', 1)->where('schoolYearId', '!=', $id)->exists();

            if ($existingActiveSchoolYear) {
                session()->flash('error', 'Deactivate the current active school year before activating another one.');
                return back();
            }
        }

        // Update the status
        $schoolYear->isActive = $request->isActive;
        $schoolYear->save();

        // Success message
        session()->flash('success', $schoolYear->isActive == 1 ? 'School year activated successfully!' : 'School year deactivated successfully!');
        return back();
    }





    /**
     * Display the specified resource.
     */
    public function show(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolYear $schoolYear)
    {
        //
    }
}
