<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class County extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('county') ? __('Input entered is not valid! Please enter your county name or code to continue.') : __('Please enter your county name or code to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $county = getCounty(trim($argument), get_class($this));

        if (optional($county)->id) {
            $this->record->set('county', strtolower($county->name));
        }

        /* $this->decision->custom(function ($input) use ($county) {
            return is_string(trim($input)) && !empty(trim($input)) && optional($county)->id ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Location::class)->any(self::class); */

        $this->decision->custom(function ($input) {
            return /* is_string(trim($input)) && */ !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Location::class)->any(self::class);
    }
}
