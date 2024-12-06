<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Models\YearLevel;
use App\Models\Section;
use App\Models\Parents;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\RegistrationPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmissionController extends Controller
{
    public function loadAdmission()
    {
        $activeSchoolYear = SchoolYear::where('isActive', 1)->first();

        // Load admissions with necessary relationships
        $allAdmission = Enrollment::with([
            'schoolYear',
            'yearLevel',
            'students.parents',
            'section'
        ])->get();

        // Loop through admissions to assign dynamic sections
        foreach ($allAdmission as $admission) {
            $assignedSection = Section::where('yearLevelId', $admission->yearLevelId)
                ->where('schoolYearId', $admission->schoolYearId)
                ->whereDoesntHave('admissions', function ($query) use ($admission) {
                    $query->where('sectionId', $admission->sectionId);
                })
                ->first();


            $assignedSection = Section::where('yearLevelId', $admission->yearLevelId)
                ->where('schoolYearId', $admission->schoolYearId)
                ->whereDoesntHave('admissions', function ($query) use ($admission) {
                    $query->where('sectionId', $admission->sectionId);
                })
                ->first();

            $admission->setAttribute('sectionAssigned', $assignedSection ? $assignedSection->sectionName : 'Not Assigned');
        }

        // Fetch additional data
        $allYearLevels = YearLevel::all();
        $allParents = Parents::all();

        return view('admin.manage-admission', [
            'allAdmission' => $allAdmission,
            'activeSchoolYear' => $activeSchoolYear,
            'allYearLevels' => $allYearLevels,
            'allParents' => $allParents,
        ]);
    }


    public function store(Request $request) {}
}
