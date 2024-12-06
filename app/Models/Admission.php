<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $primaryKey = 'admissionId';

    protected $fillable = [
        'admissionNo',
        'schoolYearId',
        'yearLevelId',
        'sectionId',
        'studentId',
    ];


    public function students()
    {
        return $this->belongsTo(Student::class, 'studentId', 'studentId');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class, 'schoolYearId', 'schoolYearId');
    }

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'yearLevelId', 'yearLevelId');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'sectionId', 'sectionId');
    }

    public function getSectionAssignedAttribute()
    {
        // Find the assigned section based on yearLevelId and schoolYearId
        $assignedSection = Section::where('yearLevelId', $this->yearLevelId)
            ->where('schoolYearId', $this->schoolYearId)
            ->whereDoesntHave('admissions', function ($query) {
                $query->where('sectionId', $this->sectionId);
            })
            ->first();

        return $assignedSection->sectionId ?? 'Not Assigned';
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'sectionId', 'sectionId');
    }

    public function medicals()
    {
        return $this->hasMany(Medical::class, 'studentId', 'studentId');
    }

    public function parents()
    {
        return $this->hasMany(Parents::class, 'parentId', 'parentId');
    }
}
