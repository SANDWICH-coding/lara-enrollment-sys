<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\YearLevel;
use App\Models\SchoolYear;
use App\Models\Billing;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SectionController extends Controller
{
    public function loadSection()
    {
        $allYearLevels = YearLevel::with(['sections' => function ($query) {
            $query->whereHas('schoolYear', function ($q) {
                $q->where('isActive', 1);
            });
        }])->get();
        $allSections = Section::paginate();
        $allSchoolYears = SchoolYear::paginate();
        return view('admin.manage-section', [
            'allYearLevels' => $allYearLevels,
            'allSections' => $allSections,
            'allSchoolYears' => $allSchoolYears,
        ]);
    }


    public function storeSection(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'schoolYearId' => 'required|exists:school_years,schoolYearId',
            'yearLevelId' => 'required|exists:year_levels,yearLevelId', // Validate that the year level exists
            'sectionName' => 'required',
        ]);

        // Check validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // Prepare data for creation
        $sectionData = $request->only(['schoolYearId', 'yearLevelId', 'sectionName']);



        $section = Section::create($sectionData);

        // Set success message
        session()->flash('success', 'New section created successfully.');

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Section created successfully.',
            'data' => $section,
        ]);
    }

    public function updateSection(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'sectionId' => 'required|exists:sections,sectionId', // Ensure the ID exists
            'sectionName' => 'required|string|max:50',
        ]);

        try {
            // Find the Section by ID and update its name
            $section = Section::findOrFail($request->sectionId);
            $section->sectionName = $request->sectionName;
            $section->save();

            // Flash success message to session
            session()->flash('success', 'The section was successfully updated.');
            return redirect('/manage-section');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }


    public function destroySection($id)
    {
        $sections = Section::findOrFail($id); // Use the route parameter
        $sections->delete();

        session()->flash('info', 'The section was deleted and cannot be recovered.');
        return redirect()->route('manage.section'); // Ensure this route name matches your list view
    }

    public function getSectionsByYearLevel($yearLevelId)
    {
        Log::info("Fetching sections for YearLevelId: $yearLevelId");
        $sections = Section::where('yearLevelId', $yearLevelId)->get();
        Log::info("Sections: ", $sections->toArray());
        return response()->json(['sections' => $sections]);
    }

    public function getSections($yearLevelId)
    {
        $activeSchoolYear = SchoolYear::where('isActive', 1)->first();

        if ($activeSchoolYear) {
            $sections = Section::where('yearLevelId', $yearLevelId)
                ->where('schoolYearId', $activeSchoolYear->schoolYearId)
                ->get(['sectionId', 'sectionName']);

            return response()->json(['sections' => $sections]);
        }

        return response()->json(['sections' => []]);
    }

    public function getDetails($yearLevelId, $sectionId)
    {
        $billings = Billing::where('yearLevelId', $yearLevelId)->get(['description', 'amount']);
        $schedules = Schedule::where('sectionId', $sectionId)
            ->get(['subjectName', 'day', 'startTime', 'endTime', 'teacherName']);

        return response()->json([
            'billings' => $billings,
            'schedules' => $schedules,
        ]);
    }
}
