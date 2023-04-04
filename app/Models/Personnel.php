<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnel extends Model
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
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'telephone',
        'email',
        'website',
        'gender',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'subscribed_at',
        'unsubscribed_at',
        '_status'
    ];

    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:personnels',
            'category_id' => 'required|integer',
            'title' => 'nullable|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'telephone' => 'nullable|string|unique:personnels',
            'email' => 'nullable|email|unique:personnels',
            'website' => 'nullable|string',
            'gender' => 'nullable|integer',
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'subscribed_at' => 'nullable|timestamp',
            'unsubscribed_at' => 'nullable|timestamp'
        ];
    }

    public static function updateRules(int $id)
    {
        return [
            '_pid' => 'nullable|string|' . Rule::unique('personnels', '_pid')->ignore($id),
            'category_id' => 'required|integer',
            'title' => 'nullable|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'telephone' => 'nullable|string|' . Rule::unique('personnels', 'telephone')->ignore($id),
            'email' => 'nullable|email|' . Rule::unique('personnels', 'email')->ignore($id),
            'website' => 'nullable|string',
            'gender' => 'nullable|integer',
            'address_line_1' => 'nullable|string',
            'address_line_2' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'country' => 'nullable|string',
            'subscribed_at' => 'nullable|timestamp',
            'unsubscribed_at' => 'nullable|timestamp'
        ];
    }
}
