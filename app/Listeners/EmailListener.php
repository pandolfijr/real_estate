<?php

namespace App\Listeners;

use App\Events\EmailEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class EmailListener
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
     * @param  \App\Events\EmailEvent  $event
     * @return void
     */
    public function handle(EmailEvent $event)
    {
         Mail::to('aryane@renatacorretoradeimoveis.com.br')
         ->cc(['contato@renatacorretoradeimoveis.com.br', 'jean@renatacorretoradeimoveis.com.br']) //com copia
         ->send(new SendMail($event->imovel));
    }
}
