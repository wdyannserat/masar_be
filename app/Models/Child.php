<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Child extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'password',
        'gender',
        'school_name',
        'points',
        'birth_date',
        'is_active',
        'parent_id',
        'notes',
        'attachment_id',
        'group_id',
        'position_id',
        'trip_id',
    ];

    protected $hidden = [
        'password'
    ];

    //* Relations */
    //****** belongsTo Relations ******/

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }


    //****** hasMany Relations ******/

    public function childSession()
    {
        return $this->hasMany(ChildSession::class);
    }

    public function childTripChecklist()
    {
        return $this->hasMany(ChildTripChecklist::class, 'child_id');
    }

    public function challengeChild()
    {
        return $this->hasMany(ChallengeChild::class);
    }

    public function childGroup()
    {
        return $this->hasMany(ChildGroup::class);
    }

    public function childSessionChecklist()
    {
        return $this->hasMany(SessionChecklist::class, 'child_id');
    }

    public function childMission()
    {
        return $this->hasMany(ChildMission::class, 'child_id');
    }

    public function itemRequests()
    {
        return $this->hasMany(ItemRequest::class, 'child_id');
    }

    //****** Many to Many Relations ******/

    public function missionPrograms()
    {
        return $this->belongsToMany(MissionProgram::class)
            ->using(ChildMission::class)
            ->withPivot(
                'progress',
                'status',
                'mission_id',
                'child_id'
            );
    }

    public function challenges()
    {
        return $this->belongsToMany(Challenge::class)->withPivot(
            'status',
            'progress'
        );
    }

    public function sessions()
    {
        return $this->belongsToMany(Session::class)->using(ChildSession::class)->withPivot(
            'id',
            'description',
            'status',
            'created_at',
        );
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot(
            'status',
            'description'
        );
    }

    public function ratedSessions(){
        return $this->belongsToMany(ProgramSession::class,'session_rates','child_id','program_session_id','id','id')->withPivot(
            'rate',
            'child_id',
            'program_session_id'
        );
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_requests', 'child_id', 'item_id', 'id', 'id')->using(ItemRequest::class)->withPivot(
            'status',
            'description'
        );
    }


    //*helper functions
    public function isActive()
    {
        return $this->is_active;
    }

    public function getBadges()
    {
        $childMissions = ChildMission::where([
            'status' => 'Done',
            'child_id' => $this->id,
        ])->get();
        $childMissions->load('missionProgram.mission');

        $missions = $childMissions->pluck('missionProgram.mission')->unique()->map(function ($mission) {
            return [
                'mission_id' => $mission->id,
                'badge_name' => $mission->badge_name,
                'badge_url'  => $mission->badge_url,
            ];
        });

        return $missions;
    }
}
