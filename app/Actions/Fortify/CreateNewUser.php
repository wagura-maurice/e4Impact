<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => Str::snake(strtolower($input['name'])),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole('guest');

        Profile::create(array_filter(array_merge(getNameParts($input['name']), [
            '_pid' => generatePID(Profile::class),
            'user_id' => $user->id,
            'telephone' => NULL,
            'national_id' => NULL,
            'gender' => NULL,
            'address_line_1' => NULL,
            'address_line_2' => NULL,
            'city' => NULL,
            'state' => NULL,
            'country' => NULL
        ])));

        return $user;
    }
}
