<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;

    protected $table = 'school_years'; // Use the correct table name
    protected $primaryKey = 'schoolYearId';

    protected $fillable = [
        'schoolYearName',
        'isActive'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'schoolYearId');
    }

}
