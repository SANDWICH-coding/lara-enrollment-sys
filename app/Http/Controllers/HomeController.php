<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use App\Models\YearLevel;
use App\Models\Parents;
use App\Models\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {

        $allParents = Parents::paginate();
        $activeSchoolYear = SchoolYear::where('isActive', 1)->first(); // Get active school year
        $allYearLevels = YearLevel::paginate();
        $allStudents = Student::paginate();

        $bounceRate = 0; // Default to 0 if not calculated
        $currentYearEnrollments = 0; // Default to 0 if no enrollments found
        $lastYearEnrollments = 0; // Default to 0 if no enrollments found

        if ($activeSchoolYear) {
            // Retrieve the last school year based on created_at column
            $lastSchoolYear = SchoolYear::where('created_at', '<', $activeSchoolYear->created_at)
                ->orderBy('created_at', 'desc')
                ->first(); // Get the most recent school year before the active school year

            if ($lastSchoolYear) {
                // Count students for the active school year (current school year)
                $currentYearEnrollments = Student::where('schoolYearId', $activeSchoolYear->schoolYearId)->count();

                // Count students for the last school year
                $lastYearEnrollments = Student::where('schoolYearId', $lastSchoolYear->schoolYearId)->count();

                // Calculate bounce rate percentage
                if ($lastYearEnrollments > 0) {
                    $bounceRate = (($currentYearEnrollments - $lastYearEnrollments) / $lastYearEnrollments) * 100;
                } else {
                    // If there were no enrollments in the last year, set bounce rate to 0
                    $bounceRate = 0;
                }
            }
        }

        return view('admin-dashboard', [
            'activeSchoolYear' => $activeSchoolYear,
            'allYearLevels' => $allYearLevels,
            'allParents' => $allParents,
            'allStudents' => $allStudents,
            'bounceRate' => $bounceRate, // Pass bounceRate safely
        ]);
    }

    public function getBounceData()
    {
        $schoolYears = SchoolYear::all(); // Retrieve all school years
        $enrollmentData = []; // Initialize an array to store enrollments data for each year

        foreach ($schoolYears as $schoolYear) {
            $currentEnrollments = Student::where('schoolYearId', $schoolYear->schoolYearId)->count();
            $maleEnrollments = Student::where('schoolYearId', $schoolYear->schoolYearId)->where('gender', 'MALE')->count();
            $femaleEnrollments = Student::where('schoolYearId', $schoolYear->schoolYearId)->where('gender', 'FEMALE')->count();

            $enrollmentData[] = [
                'schoolYear' => $schoolYear->schoolYearName,
                'totalEnrollments' => $currentEnrollments,
                'maleEnrollments' => $maleEnrollments,
                'femaleEnrollments' => $femaleEnrollments,
            ];
        }

        return response()->json([
            'enrollmentData' => $enrollmentData,
        ]);
    }
}
