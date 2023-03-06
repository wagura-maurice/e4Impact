<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        try {
            /* Updating the invoice or booking status. */
            collect(json_decode($transaction->account_reference, true))->map(function ($_reference) use ($transaction) {
                if ($transaction->transaction_category == Transaction::INVOICE) {
                    $invoice = Invoice::where('_pid', $_reference)->first();
                    $invoice->_statement = optional($invoice)->_statement ? collect(array_merge(json_decode($invoice->_statement, true), $transaction->toArray()))->toJson() : $transaction->toJson();
                    $invoice->_status = Invoice::PROCESSING;
                    $invoice->save();
                } elseif ($transaction->transaction_category == Transaction::BOOKING) {
                    $booking = Booking::where('_pid', $_reference)->first();
                    $booking->_statement = optional($booking)->_statement ? collect(array_merge(json_decode($booking->_statement, true), $transaction->toArray()))->toJson() : $transaction->toJson();
                    $booking->_status = Booking::PROCESSING;
                    $booking->save();
                } 
            });
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        try {
            /* Checking if the transaction code and status has been changed. If it has been changed, it
            will update the invoice or booking status. */
            if($transaction->wasChanged('transaction_code') && $transaction->wasChanged('_status')) {
                collect(json_decode($transaction->account_reference, true))->map(function ($_reference) use ($transaction) {
                    if ($transaction->transaction_category == Transaction::INVOICE) {
                        $invoice = Invoice::where('_pid', $_reference)->first();
                        $invoice->paid = $invoice->payable;
                        $invoice->balance = $invoice->payable - $invoice->paid;
                        $invoice->_statement = optional($invoice)->_statement ? collect(array_merge(json_decode($invoice->_statement, true), $transaction->toArray()))->toJson() : $transaction->toJson();
                        $invoice->_status = $invoice->balance < $invoice->payable ? Invoice::SETTLED : Invoice::PARTIAL;
                        $invoice->save();
                    } elseif ($transaction->transaction_category == Transaction::BOOKING) {
                        $booking = Booking::where('_pid', $_reference)->first();
                        $booking->_statement = optional($booking)->_statement ? collect(array_merge(json_decode($booking->_statement, true), $transaction->toArray()))->toJson() : $transaction->toJson();
                        $booking->_status = Booking::PROCESSED;
                        $booking->save();
                    } 
                });
            }
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());
        }
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
