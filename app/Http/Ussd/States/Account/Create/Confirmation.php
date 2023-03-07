<?php

namespace App\Http\Ussd\States\Account\Create;

use Sparors\Ussd\State;

class Confirmation extends State
{
    protected function beforeRendering(): void
    {
        $this->menu->text(__('REGISTRATION DETAILS CONFIRMATION:'))
            ->lineBreak(1)
            ->text(__('NAME : ' . ucwords($this->record->get('name'))))
            ->lineBreak(1)
            ->text('ID: ' . strtoupper($this->record->get('nationalIdentificationNumber')))
            ->lineBreak(1)
            ->text('YOB: ' . $this->record->get('yearOfBirth'))
            ->lineBreak(1)
            ->text('LOCATION: ' . ucwords($this->record->get('location') . ', ' . $this->record->get('county') . '.'))
            ->lineBreak(1)
            ->text('ACREAGE: ' . number_format($this->record->get('acreage') ?? 0, 2))
            ->lineBreak(1)
            ->listing([
                __('Continue'),
                __('Cancel')
            ]);
    }

    protected function afterRendering(string $argument): void
    {
        $this->decision
            ->equal('1', \App\Http\Ussd\Actions\Account\Create::class)
            ->equal('2', \App\Http\Ussd\States\Terminate::class)
            ->any(self::class);
    }
}
