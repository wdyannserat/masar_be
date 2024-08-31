<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'birth_date',
        'address',
        'role',
        'password',
        'gender',
        'is_active',
        'attachment_id',
        'volunteering_start_date',
        'volunteering_end_date',
        'notes',
        'number_of_children',
        'parent_full_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    ///* Relations */
    ///****** belongsTo Relations ******//
    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
    ///****** hasMany Relations ******//

    public function facilitatorGroup()
    {
        return $this->hasMany(FacilitatorGroup::class, 'facilitator_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'parent_id', 'id');
    }

    public function surveyUser()
    {
        return $this->hasMany(SurveyUser::class);
    }

    public function actualFacilitatorTrip()
    {
        return $this->hasMany(FacilitatorTrip::class, 'actual_facilitator_id', 'id')->whereNotNull('actual_facilitator_id');
    }

    public function expectedFacilitatorTrip()
    {
        return $this->hasMany(FacilitatorTrip::class, 'expected_facilitator_id', 'id')->whereNotNull('expected_facilitator_id');
    }


    ///****** Many to Many Relations ******//

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'facilitator_group', 'facilitator_id', 'group_id', 'id', 'id')->using(FacilitatorGroup::class);
    }



    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'parent_id', 'survey_id')->using(SurveyUser::class)
            ->withPivot(
                'id',
                'status'
            );
    }

    public function tripsForActualFacilitator()
    {
        return $this->belongsToMany(Trip::class, 'facilitator_trip', 'actual_facilitator_id', 'id')->using(FacilitatorTrip::class)
            ->withPivot(
                'id',
                'type',
                'date_of_trip',
                'reason_of_switch',
                'expected_facilitator_id',
                'actual_facilitator_id',
                'trip_id'
            );
    }

    public function tripsForExpectedFacilitator()
    {
        return $this->belongsToMany(Trip::class, 'facilitator_trip', 'expected_facilitator_id', 'id')->using(FacilitatorTrip::class)
            ->wherePivotNotNull('expected_facilitator_id')
            ->withPivot(
                'id',
                'type',
                'date_of_trip',
                'reason_of_switch',
                'expected_facilitator_id',
                'actual_facilitator_id',
                'trip_id'
            );
    }
    //*helper functions
    public function isActive()
    {
        return $this->is_active;
    }
}
