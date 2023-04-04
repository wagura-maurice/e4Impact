<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_pid',
        'user_id',
        'telephone',
        'national_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country'
    ];

    /**
     * It returns an array of rules that can be used to validate a profile
     * 
     * @return An array of rules for the Profile model.
     */
    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:accounts',
            'user_id' => 'required|integer|unique:accounts',
            'telephone' => 'nullable|string|unique:accounts',
            'national_id' => 'nullable|string|unique:accounts',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'gender' => 'nullable|integer',
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string'
        ];
    }

    /**
     * It returns an array of rules for updating a profile.
     * 
     * @param int id The id of the profile you want to update.
     * 
     * @return An array of rules for the update method.
     */
    public static function updateRules(int $id)
    {
        return [
            '_pid' => 'nullable|string|' . Rule::unique('accounts', '_pid')->ignore($id),
            'user_id' => 'nullable|integer|' . Rule::unique('accounts', 'user_id')->ignore($id),
            'telephone' => 'nullable|string|' . Rule::unique('accounts', 'telephone')->ignore($id),
            'national_id' => 'nullable|string|' . Rule::unique('accounts', 'national_id')->ignore($id),
            'first_name' => 'nullable|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'gender' => 'nullable|integer',
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string'
        ];
    }

    /**
     * This post belongs to a user.
     * 
     * @return BelongsTo A relationship between the user and the question.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
