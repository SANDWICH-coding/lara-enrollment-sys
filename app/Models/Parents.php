<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table = 'parents';
    protected $primaryKey = 'parentId';

    protected $fillable = [
        'salutation',
        'firstName',
        'lastName',
        'dob',
        'contactNo',
        'address',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'parentId', 'parentId');
    }
}
