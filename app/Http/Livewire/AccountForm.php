<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Actions\Fortify\UpdateUserProfileInformation;

class AccountForm extends Component
{
    public $state = [];

    /**
     * > The `mount()` function is called when the component is mounted
     */
    public function mount()
    {
        $this->state = auth()->user()->withoutRelations()->toArray();
    }

    /**
     * It updates the user's profile information
     * 
     * @param UpdateUserProfileInformation updater This is the class that will handle the updating of
     * the user's profile information.
     */
    public function updateProfileInformation(UpdateUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            auth()->user(),
            $this->state
        );

        session()->flash('status', 'Account successfully updated');
    }

    /**
     * The render() function returns the view file that will be used to display the component
     * 
     * @return The view file.
     */
    public function render()
    {
        return view('livewire.account-form');
    }
}
