<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPersonnel extends Model
{
    use HasFactory;

    protected $table = 'membership_personnel';

    protected $primaryKey = 'membership_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membership_id',
        'personnel_id'
    ];

    /**
     * It creates a rule for the membership_id and personnel_id.
     * 
     * @return An array of rules.
     */
    public static function createRules()
    {
        return [
            'membership_id' => 'required|integer',
            'personnel_id' => 'required|integer'
        ];
    }

    /**
     * A function that is used to validate the data that is being passed to the database.
     * 
     * @return An array of rules for the update method.
     */
    public static function updateRules()
    {
        return [
            'membership_id' => 'nullable|integer',
            'personnel_id' => 'nullable|integer'
        ];
    }
}
