<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Landmark extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text($this->record->get('landmark') ? __('Input entered is not valid! Please enter your nearest school to continue.') : __('Please enter your nearest school to continue.'));
    }

    protected function afterRendering(string $argument): void
    {
        $this->record->set('landmark', strtoupper(trim($argument)));

        $this->decision->custom(function ($input) {
            return is_string(trim($input)) && !empty(trim($input)) ? true : false;
        }, \App\Http\Ussd\States\Account\Create\Acreage::class)->any(self::class);
    }
}
