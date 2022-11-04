<?php

namespace App\Listeners;

use App\Events\XeroCheckEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Http\Controllers\XeroController;
use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\WarningMails;

class XeroCheckEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  XeroCheckEvent  $event
     * @return void
     */
    public function handle(XeroCheckEvent $event)
    {





        // if true search by result data invoice to orders and make it paid





    }
}
