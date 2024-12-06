<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'studentId';

    protected $fillable = [
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
        'birthCertificateFile',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'studentId', 'studentId');
    }

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'yearLevelId');
    }



    public function medicals()
    {
        return $this->hasMany(Medical::class, 'studentId', 'studentId'); // Adjust 'id' if your primary key is custom
    }

    public function payments()
    {
        return $this->hasMany(RegistrationPayment::class, 'studentId', 'studentId'); // Adjust 'id' if needed
    }

    public function registrationPayment()
    {
        return $this->hasOne(RegistrationPayment::class, 'studentId', 'studentId');
    }

    public function parents()
    {
        return $this->belongsTo(Parents::class, 'parentId', 'parentId');
    }
}
