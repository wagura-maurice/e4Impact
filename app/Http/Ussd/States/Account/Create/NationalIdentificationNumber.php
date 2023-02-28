<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class NationalIdentificationNumber extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('nationalIdentificationNumber') ? __('Input entered is not valid! Please enter your national identification number to continue.') : __('Please enter your national identification number to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('nationalIdentificationNumber', strtoupper(trim($argument)));

        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\YearOfBirth::class)->any(self::class);
    }
}
