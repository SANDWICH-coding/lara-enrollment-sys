<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'sections';
    protected $primaryKey = 'sectionId';

    protected $fillable = [
        'schoolYearId',
        'yearLevelId',
        'sectionName',
    ];

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'yearLevelId');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'sectionId', 'sectionId');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'schoolYearId');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class, 'sectionId', 'sectionId');
    }


    public function getSections($yearLevelId)
    {
        $sections = Section::where('yearLevelId', $yearLevelId)->get(['sectionId', 'sectionName']);

        if ($sections->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No sections found for the selected year level.',
            ]);
        }

        return response()->json([
            'success' => true,
            'sections' => $sections,
        ]);
    }
}
