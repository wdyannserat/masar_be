<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FacilitatorGroup extends Pivot
{
    use HasFactory;

    protected $table = 'facilitator_group';

    protected $fillable = [
        'notes',
        'facilitator_id',
        'group_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function facilitator()
    {
        return $this->belongsTo(User::class, 'facilitator_id', 'id');
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}
