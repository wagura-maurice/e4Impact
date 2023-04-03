<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Actions\Fortify\UpdateUserPassword;

class PasswordChangeForm extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    /**
     * It updates the user's password
     * 
     * @param UpdateUserPassword updater This is the class that will handle the updating of the user's
     * password.
     */
    public function changePassword(UpdateUserPassword $updater)
    {
        $this->resetErrorBag();

        $updater->update(auth()->user(), $this->state);

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        session()->flash('status', 'Password successfully changed');
    }

    /**
     * The render() function returns the view file that will be used to display the component
     * 
     * @return The view file.
     */
    public function render()
    {
        return view('livewire.password-change-form');
    }
}
