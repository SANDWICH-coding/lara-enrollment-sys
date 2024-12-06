<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Section;
use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function loadSchedule()
    {
        $allYearLevels = YearLevel::with(['sections' => function ($query) {
            $query->whereHas('schoolYear', function ($q) {
                $q->where('isActive', 1);
            });
        }])->get();
        $allSections = Section::paginate();
        $allSchedules = Schedule::paginate();
        return view('admin.manage-schedule', [
            'allYearLevels' => $allYearLevels,
            'allSections' => $allSections,
            'allSchedules' => $allSchedules,
        ]);
    }

    public function storeSchedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'yearLevelId' => 'required|exists:year_levels,yearLevelId',
            'sectionId' => 'required|exists:sections,sectionId',
            'subjectName' => 'required|string|max:255',
            'day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
            'teacherName' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // Check for schedule conflict
        $conflictingSchedules = Schedule::where('sectionId', $request->sectionId)
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query->where(function ($subQuery) use ($request) {
                    // Check if the start time falls within an existing schedule
                    $subQuery->where('startTime', '<', $request->endTime)
                        ->where('endTime', '>', $request->startTime);
                });
            })
            ->exists();

        if ($conflictingSchedules) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'scheduleConflict' => ['This schedule conflicts with an existing one. Please adjust the time or day.'],
                ],
            ]);
        }

        // Save the schedule
        $scheduleData = $request->only([
            'yearLevelId',
            'sectionId',
            'subjectName',
            'day',
            'startTime',
            'endTime',
            'teacherName',
        ]);

        $schedule = Schedule::create($scheduleData);

        session()->flash('success', 'New schedule created successfully.');

        return response()->json([
            'success' => true,
            'message' => 'Schedule created successfully.',
            'data' => $schedule,
        ]);
    }



    public function updateSchedule(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'scheduleId' => 'required|exists:schedules,scheduleId', // Ensure the ID exists
            'subjectName' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'teacherName' => 'required|string|max:255',
        ]);

        // Find the Schedule by ID and update its details
        $schedule = Schedule::findOrFail($request->scheduleId);
        $schedule->subjectName = $request->subjectName;
        $schedule->day = $request->day;
        $schedule->time = $request->time;
        $schedule->teacherName = $request->teacherName;
        $schedule->save();

        // Pass the success message to the session
        session()->flash('success', 'Schedule updated successfully!');
        return redirect('/manage-schedule');
    }

    public function destroySchedule($id)
    {
        $schedule = Schedule::findOrFail($id); // Use the route parameter
        $schedule->delete();

        session()->flash('info', 'The schedule was deleted and cannot be recovered.');
        return redirect()->route('manage.schedule'); // Ensure this route name matches your list view
    }
}
