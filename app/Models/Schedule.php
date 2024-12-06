<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'schedules';
    protected $primaryKey = 'scheduleId';

    protected $fillable = [
        'sectionId',
        'subjectName',
        'day',
        'startTime',
        'endTime',
        'teacherName',
    ];

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'yearLevelId');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'sectionId');
    }

    

}
