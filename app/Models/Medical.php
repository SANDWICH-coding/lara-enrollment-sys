<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    use HasFactory;

    protected $primaryKey = 'medicalId';

    protected $casts = [
        'attitudes' => 'array',
    ];    

    protected $fillable = [
        'studentId',
        'illness',
        'allergies',
        'dental',
        'attitudes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentId', 'studentId');
    }
}
