<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;

class TwoFactorForm extends Component
{
    public $showQrCode = false;
    public $showRecoveryCodes = false;

    /**
     * It enables two factor authentication for the user
     * 
     * @param EnableTwoFactorAuthentication enable The EnableTwoFactorAuthentication instance.
     */
    public function enableTwoFactorAuth(EnableTwoFactorAuthentication $enable)
    {
        $enable(Auth::user());

        $this->showQrCode = true;
        $this->showRecoveryCodes = true;
    }

    /**
     * > Disable two factor authentication for the currently logged in user
     * 
     * @param DisableTwoFactorAuthentication disable The name of the route you want to use to disable
     * two factor authentication.
     */
    public function disableTwoFactorAuth(DisableTwoFactorAuthentication $disable)
    {
        $disable(Auth::user());
    }

    /**
     * *|MARKER_CURSOR|*
     */
    public function showRecoveryCodes()
    {
        $this->showRecoveryCodes = true;
    }

    /**
     * It calls the `GenerateNewRecoveryCodes` class, which is a `Closure` that is passed to the
     * `regenerateRecoveryCodes` function
     * 
     * @param GenerateNewRecoveryCodes generate This is the class that will be used to generate the new
     * recovery codes.
     */
    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate)
    {
        $generate(Auth::user());

        $this->showRecoveryCodes = true;
    }

    /**
     * It returns the user object of the currently logged in user
     * 
     * @return The user object.
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * The render() function returns the view that will be rendered by Livewire
     * 
     * @return The view file.
     */
    public function render()
    {
        return view('livewire.two-factor-form');
    }
}
