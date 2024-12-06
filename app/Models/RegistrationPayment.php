<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationPayment extends Model
{
    use HasFactory;

    protected $table = 'payment_registrations';
    protected $primaryKey = 'paymentRegistrationId';

    protected $fillable = [
        'studentId',
        'paymentType',
        'receiptPhoto',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentId', 'studentId');
    }

}
