<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    //****** hasMany Relations ******/

    public function positionTrip()
    {
        return $this->hasMany(PositionTrip::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function tripFacilitators()
    {
        return $this->hasMany(FacilitatorTrip::class, 'trip_id', 'id');
    }

    //****** Many to Many Relations ******/

    public function positions()
    {
        return $this->belongsToMany(Position::class)->using(PositionTrip::class);
    }

    public function supervisedActualFacilitators()
    {
        return $this->belongsToMany(User::class, 'facilitator_trip', 'trip_id', 'actual_facilitator_id', 'id', 'id')
            ->wherePivotNotNull('actual_facilitator_id')
            ->using(FacilitatorTrip::class);
    }
}
