<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\YearLevel;
use App\Models\Enrollment;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function storeStudentWithMedical(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lrn' => 'nullable|string|max:255',
            'yearLevelId' => 'required|exists:year_levels,yearLevelId',
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'nickName' => 'nullable|string|max:255',
            'gender' => 'required|in:MALE,FEMALE',
            'dob' => 'required|date',
            'placeOfBirth' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'parentId' => 'required|exists:parents,parentId',
            'birthCertificateFile' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // Age validation
        $dob = new \DateTime($request->dob);
        $june30 = new \DateTime(date('Y') . '-06-30');
        $age = $dob->diff($june30)->y;

        $yearLevel = YearLevel::find($request->yearLevelId);

        if ($yearLevel) {
            $yearLevelName = strtoupper($yearLevel->yearLevelName);

            if ($yearLevelName === 'NURSERY' && $age < 3) {
                return response()->json([
                    'success' => false,
                    'errors' => ['dob' => ['Student must be at least 3 years old as of June 30 for NURSERY.']],
                ]);
            } elseif ($yearLevelName === 'K1' && $age < 4) {
                return response()->json([
                    'success' => false,
                    'errors' => ['dob' => ['Student must be at least 4 years old as of June 30 for K1.']],
                ]);
            } elseif ($yearLevelName === 'K2' && $age < 5) {
                return response()->json([
                    'success' => false,
                    'errors' => ['dob' => ['Student must be at least 5 years old as of June 30 for K2.']],
                ]);
            } elseif (str_starts_with($yearLevelName, 'GRADE') && $age < 7) {
                return response()->json([
                    'success' => false,
                    'errors' => ['dob' => ['Student must be at least 7 years old for this grade level.']],
                ]);
            }
        }

        // Process and save the data if no validation error
        $studentData = $request->only([
            'lrn',
            'lastName',
            'firstName',
            'middleName',
            'nickName',
            'gender',
            'dob',
            'placeOfBirth',
            'religion',
            'parentId',
        ]);

        if ($request->hasFile('birthCertificateFile')) {
            $file = $request->file('birthCertificateFile');
            $filePath = $file->store('birth_certificates', 'public');
            $studentData['birthCertificateFile'] = $filePath;
        }

        $student = Student::create($studentData);

        $student->medicals()->create([
            'illness' => $request->illness,
            'allergies' => $request->allergies,
            'dental' => $request->dental,
            'attitudes' => $request->attitudes, // Store as an array
        ]);


        // Fetch the active school year
        $activeSchoolYear = SchoolYear::where('isActive', 1)->first();

        if (!$activeSchoolYear) {
            return response()->json([
                'success' => false,
                'message' => 'No active school year found.',
            ], 400);
        }

        // Construct the school year code (e.g., "ADM2023")
        $schoolYearCode = 'ADM' . preg_replace('/-.*$/', '', $activeSchoolYear->schoolYearName);

        // Fetch the last admission number for the active school year
        $lastAdmission = Enrollment::where('admissionNo', 'LIKE', "$schoolYearCode%")
            ->orderBy('admissionNo', 'desc')
            ->first();

        // Calculate the next admission number
        $nextAdmissionNumber = $lastAdmission
            ? intval(substr($lastAdmission->admissionNo, -4)) + 1
            : 1;

        // Format the new admission number (e.g., "ADM2023-0001")
        $admissionNo = sprintf('%s-%04d', $schoolYearCode, $nextAdmissionNumber);

        // Store in admissions table
        Enrollment::create([
            'admissionNo' => $admissionNo,
            'schoolYearId' => $request->schoolYearId,
            'yearLevelId' => $request->yearLevelId,
            'sectionId' => $request->sectionId,
            'studentId' => $student->studentId,
        ]);


        session()->flash('success', 'Student added successfully.');

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully.',
            'data' => $student,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
