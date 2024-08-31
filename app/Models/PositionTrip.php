<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PositionTrip extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'trip_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }


    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}