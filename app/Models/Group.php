<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'children_count',
        'notes',
        'age_type_id',
        'program_id',
    ];
    //* Relations */
    //****** belongsTo Relations ******/
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function ageType()
    {
        return $this->belongsTo(AgeType::class, 'age_type_id');
    }


    //****** hasMany Relations ******/
    public function groupSchedules()
    {
        return $this->hasMany(GroupSchedule::class);
    }

    public function facilitatorGroup()
    {
        return $this->hasMany(FacilitatorGroup::class);
    }

    public function childGroup()
    {
        return $this->hasMany(ChildGroup::class);
    }


    //****** Many to Many Relations ******/

    public function facilitators()
    {
        return $this->belongsToMany(User::class, 'facilitator_group', 'group_id', 'facilitator_id', 'id', 'id');
    }

    public function children()
    {
        return $this->belongsToMany(Child::class)->using(ChildGroup::class);
    }

}
