<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'quantity',
        'name',
        'point_price',
        'category',
        'attachment_id'
    ];
    //* Relations */
    //****** belongsTo Relations ******/
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
    //****** hasMany Relations ******/

    public function itemRequests()
    {
        return $this->hasMany(ItemRequest::class, 'item_id');
    }

    //****** Many to Many Relations ******/

    public function children()
    {
        return $this->belongsToMany(Child::class, 'item_requests', 'item_id', 'child_id', 'id', 'id')
            ->using(ItemRequest::class)
            ->withPivot(
                'id',
                'status'
            );
    }
}