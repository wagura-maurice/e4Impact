<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbilityRole extends Model
{
    use HasFactory;

    protected $table = 'ability_role';

    protected $primaryKey = 'ability_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'ability_id'
    ];

    /**
     * > This function returns an array of rules that are used to validate the data that is passed to
     * the model when creating a new record
     * 
     * @return An array of rules.
     */
    public static function createRules()
    {
        return [
            'role_id' => 'required|integer',
            'ability_id' => 'required|integer'
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
            'role_id' => 'nullable|integer',
            'ability_id' => 'nullable|integer'
        ];
    }
}
