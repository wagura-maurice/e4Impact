<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnstructuredSupplementaryServiceData extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_pid',
        'telephone',
        'short_code',
        'network',
        'transaction_amount',
        '_status'
    ];

    /**
     * It creates rules for the fields in the form.
     * 
     * @return An array of rules
     */
    public static function createRules()
    {
        return [
            '_pid' => 'required|string|unique:unstructured_supplementary_service_data',
            'telephone' => 'required|string',
            'short_code' => 'required|string',
            'network' => 'nullable|string',
            'transaction_amount' => 'nullable|numeric',
            '_status' => 'nullable|string'
        ];
    }

    /**
     * A function that returns an array of rules for updating a record in the database.
     * 
     * @param int id The id of the record you want to update.
     * 
     * @return The updateRules function is returning an array of rules.
     */
    public static function updateRules(int $id)
    {
        return [
            '_pid' => 'nullable|string|'.Rule::unique('unstructured_supplementary_service_data', '_pid')->ignore($id),
            'telephone' => 'nullable|string',
            'short_code' => 'nullable|string',
            'network' => 'nullable|string',
            'transaction_amount' => 'nullable|numeric',
            '_status' => 'nullable|string'
        ];
    }
}
