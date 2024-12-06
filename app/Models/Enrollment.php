<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model 
{

  use HasFactory;

  protected $primaryKey = 'enrollmentId';

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

  public function parents()
  {
      return $this->hasMany(Parents::class, 'parentId', 'parentId');
  }

}