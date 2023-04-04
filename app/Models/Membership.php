<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    // STATUS
    const PENDING = 0;
    const INACTIVE = 1;
    const ACTIVE = 2;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_pid',
        'category_id',
        'name',
        'slug',
        'description',
        'telephone',
        'email',
        'logo',
        'website',
        'subscribed_at',
        'unsubscribed_at',
        '_status'
    ];

    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:memberships',
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'slug' => 'nullable|string|unique:memberships',
            'description' => 'nullable|string',
            'telephone' => 'nullable|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|string',
            'website' => 'nullable|string',
            'subscribed_at' => 'nullable|timestamp',
            'unsubscribed_at' => 'nullable|timestamp'
        ];
    }

    public static function updateRules(int $id)
    {
        return [
            '_pid' => 'nullable|string|' . Rule::unique('memberships', '_pid')->ignore($id),
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'slug' => 'nullable|string|' . Rule::unique('memberships', 'slug')->ignore($id),
            'description' => 'nullable|string',
            'telephone' => 'nullable|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|string',
            'website' => 'nullable|string',
            'subscribed_at' => 'nullable|timestamp',
            'unsubscribed_at' => 'nullable|timestamp'
        ];
    }
}
