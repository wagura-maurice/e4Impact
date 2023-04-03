<?php

namespace App\Models;

use App\Traits\HasGravatar;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasGravatar, TwoFactorAuthenticatable, SoftDeletes;

    // status
    const PENDING = 0;
    const ACTIVE = 1;
    const INACTIVE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * The createRules function creates the validation rules for the user registration form
     *
     * @return An array of rules.
     */
    public static function createRules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'email_verified_at' => 'nullable|string|confirmed',
            'password' => 'required|string|min:8|confirmed',
            'remember_token' => 'nullable|string'
        ];
    }

    /**
     * This function returns an array of rules that will be used to validate the input data
     *
     * @param int id The ID of the user you want to update.
     * @return An array of rules.
     */
    public static function updateRules(int $id)
    {
        return [
            'name' => 'nullable|string',
            'email' => 'nullable|email|'.Rule::unique('users', 'email')->ignore($id),
            'email_verified_at' => 'nullable|string',
            'password' => 'nullable|string',
            'remember_token' => 'nullable|string'
        ];
    }

    /**
     * The attributes to be appended on each retrieval.
     *
     * @var array
     */
    protected $appends = [
        'isSuperAdministrator',
        'isAdministrator',
        'isManager',
        'isGuest'
    ];

    /**
     * If the user has a role with the slug of super_administrator, then return true
     * 
     * @return bool A boolean value.
     */
    public function getIsSuperAdministratorAttribute(): bool
    {
        return $this->roles->contains('slug', 'super_administrator');
    }

    /**
     * If the user's roles collection contains a role with the slug of administrator, then return true
     * 
     * @return bool A boolean value.
     */
    public function getIsAdministratorAttribute(): bool
    {
        return $this->roles->contains('slug', 'administrator');
    }

    /**
     * If the user has a role with the slug of 'manager', return true
     * 
     * @return bool A boolean value.
     */
    public function isManager(): bool
    {
        return $this->roles->contains('slug', 'manger');
    }

    /**
     * If the user has a role with the slug "guest", then the user is a guest
     * 
     * @return bool A boolean value.
     */
    public function getIsGuestAttribute(): bool
    {
        return $this->roles->contains('slug', 'guest');
    }

    /**
     * This function returns an array of all the abilities that the user has
     *
     * @return An array of the abilities of the user.
     */
    public function abilities()
    {
        return $this->roles->map->abilities->flatten()->pluck('slug')->unique();
    }

    /**
     * It takes a role as a parameter, and if the role is a string, it will find the role by its slug,
     * and if it's not a string, it will just use the role that was passed in
     * 
     * @param role The role to assign to the user. This can be either a Role object, or a string with
     * the role's slug or id.
     * 
     * @return The role is being returned.
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }

        return $this->roles()->sync($role, false);
        // return $this->roles()->syncWithoutDetaching($role);
    }

    /**
     * Detach the role from the user
     * 
     * @param role The role to be assigned to the user.
     * 
     * @return The return value is a boolean.
     */
    public function unassignRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * > The `account()` function returns a `BelongsTo` relationship between the `User` model and the
     * `Account` model
     * 
     * @return BelongsTo A BelongsTo relationship.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'id', 'user_id');
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
