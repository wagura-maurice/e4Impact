<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPersonnel extends Model
{
    use HasFactory;

    protected $table = 'personnel_project';

    protected $primaryKey = 'project_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'personnel_id'
    ];

    /**
     * It creates a rule for the project_id and personnel_id.
     * 
     * @return An array of rules.
     */
    public static function createRules()
    {
        return [
            'project_id' => 'required|integer',
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
            'project_id' => 'nullable|integer',
            'personnel_id' => 'nullable|integer'
        ];
    }
}
