<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipPersonnel extends Model
{
    use HasFactory;

    protected $table = 'partnership_personnel';

    protected $primaryKey = 'partnership_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partnership_id',
        'personnel_id'
    ];

    /**
     * It creates a rule for the partnership_id and personnel_id.
     * 
     * @return An array of rules.
     */
    public static function createRules()
    {
        return [
            'partnership_id' => 'required|integer',
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
            'partnership_id' => 'nullable|integer',
            'personnel_id' => 'nullable|integer'
        ];
    }
}
