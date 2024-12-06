<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'billings';
    protected $primaryKey = 'billingId';

    protected $fillable = [
        'yearLevelId',
        'description',
        'amount',
    ];

    public function yearLevel()
    {
        return $this->belongsTo(YearLevel::class, 'yearLevelId');
    }
}
