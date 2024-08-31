<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildGroup extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'status',
        'description',
        'child_id',
        'group_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }


    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}