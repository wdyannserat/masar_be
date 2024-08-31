<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilitatorTrip extends Model
{
    use HasFactory;

    protected $table = 'facilitator_trip';

    protected $fillable = [
        'type',
        'date_of_trip',
        'reason_of_switch',
        'expected_facilitator_id',
        'actual_facilitator_id',
        'trip_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function expectedFacilitator()
    {
        return $this->belongsTo(User::class, 'expected_facilitator_id', 'id');
    }

    public function actualFacilitator()
    {
        return $this->belongsTo(User::class, 'actual_facilitator_id', 'id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id', 'id');
    }


    //****** hasMany Relations ******/


    public function childTripChecklists()
    {
        return $this->hasMany(ChildTripChecklist::class, 'trip_id', 'id');
    }

    //****** Many to Many Relations ******/

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_trip_checklists', 'monitor_trip_id', 'child_id', 'id', 'id')
            ->using(ChildTripChecklist::class)
            ->withPivot(
                'attendance',
                'date',
                'created_at'
            );
    }
}
