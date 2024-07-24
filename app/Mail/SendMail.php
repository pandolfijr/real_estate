<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $imovel;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($imovel)
    {
        $this->imovel = $imovel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.template')
            ->subject('Alteração de Status de Imóvel | Renata Corretora de Imóveis')
            ->with([
                'status_anterior' => $this->imovel->status_anterior,
                'status_atual' => $this->imovel->status_atual,
                'usuario' => $this->imovel->usuario->name,
                'usuario_email' => $this->imovel->usuario->email,
                'id_property' => $this->imovel->id_property,
                'referencia' => $this->imovel->referencia,
                'descricao_imovel' => $this->imovel->descricao_imovel,
                'link' => $this->imovel->link,
                'hora_atual' => Carbon::now()->format('d/m/Y H:i:s'),
            ]);
    }
}
