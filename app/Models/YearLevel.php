<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearLevel extends Model
{
    use HasFactory;

    protected $table = 'year_levels';
    protected $primaryKey = 'yearLevelId';

    protected $fillable = [
        'yearLevelName',
    ];

    // Define the relationship with sections
    public function sections()
    {
        return $this->hasMany(Section::class, 'yearLevelId', 'yearLevelId');
    }


    public function students()
    {
        return $this->hasMany(Student::class, 'yearLevelId', 'yearLevelId');
    }

    // Define the relationship with billings
    public function billings()
    {
        return $this->hasMany(Billing::class, 'yearLevelId', 'yearLevelId');
    }

}
