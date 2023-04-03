<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use App\Http\Resources\AbilityResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\AbilityFormRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ability extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'configuration'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'configuration' => 'collection'
    ];

    /**
     * This function returns the name of the form request class that will be used to validate the
     * request.
     * 
     * @return string The class name of the request class.
     */
    protected function getRequestClass(): string
    {
        return AbilityFormRequest::class;
    }

    /**
     * Return the resource class that should be used for this model.
     * 
     * @return string The resource class for the ability model.
     */
    protected function getResourceClass(): string
    {
        return AbilityResource::class;
    }

    /**
     * > This function returns an array of rules that are used to validate the data that is passed to
     * the `create` function
     * 
     * @return An array of rules for the create method.
     */
    public static function createRules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:abilities',
            'description' => 'nullable|string',
            'configuration' => 'nullable|string'
        ];
    }

    /**
     * > The `updateRules` function returns an array of rules that are used to validate the `update`
     * request
     * 
     * @param int id The id of the ability you're updating.
     * 
     * @return An array of rules for the update method.
     */
    public static function updateRules(int $id)
    {
        return [
            'name' => 'nullable|string',
            'slug' => 'nullable|string|' . Rule::unique('abilities', 'slug')->ignore($id),
            'description' => 'nullable|string',
            'configuration' => 'nullable|string'
        ];
    }

    /**
     * A user can have many roles, and a role can have many users.
     * 
     * @return BelongsToMany A collection of roles that belong to the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
