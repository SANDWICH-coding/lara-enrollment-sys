<?php

namespace App\Http\Controllers;

use App\Models\YearLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YearLevelController extends Controller
{
    public function loadYearLevel()
    {
        $allYearLevels = YearLevel::paginate();
        return view('admin.manage-year-level', [
            'allYearLevels' => $allYearLevels
        ]);
    }

    public function storeYearLevel(Request $request)
    {
        $request->validate([
            'yearLevelName' => 'required|string|max:50',
        ]);

        YearLevel::create($request->all());
        // Pass the success message to the session
        session()->flash('success', 'New year level added successfully!');
        return redirect('/manage-year-level');
    }

    public function updateYearLevel(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'yearLevelId' => 'required|exists:year_levels,yearLevelId', // Ensure the ID exists
            'yearLevelName' => 'required|string|max:50',
        ]);

        // Find the Year Level by ID and update its name
        $yearLevel = YearLevel::findOrFail($request->yearLevelId);
        $yearLevel->yearLevelName = $request->yearLevelName;
        $yearLevel->save();

        // Pass the success message to the session
        session()->flash('success', 'The year level was successfully updated.');
        return redirect('/manage-year-level');
    }

    public function destroyYearLevel($id)
    {
        $yearLevel = YearLevel::findOrFail($id); // Use the route parameter
        $yearLevel->delete();

        session()->flash('info', 'The year level was deleted and cannot be recovered.');
        return redirect()->route('manage.year.level'); // Ensure this route name matches your list view
    }
}
