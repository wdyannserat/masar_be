<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemRequest extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'status',
        'item_id',
        'child_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    //****** hasMany Relations ******/

    //****** Many to Many Relations ******/
}