<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class District extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('county') ? __('Input entered is not valid! Please enter your county name or code to continue.') : __('Please enter your county name or code to continue.'));
    }

    protected function afterRendering($argument): void
    {
        $county = getCounty(trim($argument));

        if (optional($county)->id) {
            $this->record->set('county', strtolower($county->code));
            $this->record->set('county_number', strtolower($county->code));
        }

        $this->decision->custom(function ($input) {
            return !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Location::class)->any(self::class);
    }
}
