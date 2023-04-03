<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    protected $primaryKey = 'role_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    /**
     * It creates a rule for the user_id and role_id.
     * 
     * @return An array of rules.
     */
    public static function createRules()
    {
        return [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer'
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
            'user_id' => 'nullable|integer',
            'role_id' => 'nullable|integer'
        ];
    }
}
