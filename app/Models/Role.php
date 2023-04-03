<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
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
     * This function returns the name of the request class that will be used to validate the request.
     * 
     * @return string The request class that will be used to validate the request.
     */
    protected function getRequestClass(): string
    {
        return RoleFormRequest::class;
    }
    
    /**
     * Return the resource class that should be used for this resource.
     * 
     * @return string The resource class that will be used to transform the model.
     */
    protected function getResourceClass(): string
    {
        return RoleResource::class;
    }

    /**
     * It creates a rule for the create method.
     * 
     * @return An array of rules for the create method.
     */
    public static function createRules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:roles',
            'description' => 'nullable|string',
            'configuration' => 'nullable|string'
        ];
    }

    /**
     * > The `updateRules` function returns an array of rules that are used to validate the data that
     * is passed to the `update` function
     * 
     * @param int id The id of the record you want to update.
     * 
     * @return An array of rules for the update method.
     */
    public static function updateRules(int $id)
    {
        return [
            'name' => 'nullable|string',
            'slug' => 'nullable|string|' . Rule::unique('roles', 'slug')->ignore($id),
            'description' => 'nullable|string',
            'configuration' => 'nullable|string'
        ];
    }

    /**
     * It takes a string or an Ability object and attaches it to the user
     * 
     * @param ability The ability to check for. This can be a string or an Ability object.
     * 
     * @return The return value is a collection of the roles that were synced.
     */
    public function allowTo($ability)
    {
        if (is_string($ability)) {
            $ability = Ability::where('slug', $ability)->firstOrFail();
        }

        return $this->roles()->sync($ability, false);
    }

    /**
     * > This function will remove the ability from the user
     * 
     * @param ability The name of the ability you want to disallow.
     */
    public function disallowTo($ability)
    {
        return $this->roles()->detach($ability);
    }

    /**
     * A user can have many abilities, and an ability can belong to many users.
     * 
     * @return BelongsToMany A collection of abilities
     */
    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }
}
