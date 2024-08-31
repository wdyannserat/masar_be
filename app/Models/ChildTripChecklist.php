<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildTripChecklist extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'attendance',
        'description',
        'facilitator_trip_id',
        'child_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    public function facilitatorTrip()
    {
        return $this->belongsTo(FacilitatorTrip::class, 'trip_id');
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}
