<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipCategory extends Model
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
        'template'
    ];
    
    public static function createRules()
    {
        return [
            'name' => 'required|string',
            'slug' => 'required|string|unique:membership_categories',
            'description' => 'nullable|string',
            'configuration' => 'nullable|string'
        ];
    }

    public static function updateRules(int $id)
    {
        return [
            'name' => 'nullable|string',
            'slug' => 'nullable|string|' . Rule::unique('membership_categories', 'slug')->ignore($id),
            'description' => 'nullable|string',
            'configuration' => 'nullable|string'
        ];
    }
}
