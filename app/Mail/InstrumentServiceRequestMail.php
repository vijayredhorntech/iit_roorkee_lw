<?php
namespace App\Mail;

use App\Models\Instrument;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstrumentServiceRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The instrument instance.
     *
     * @var Instrument
     */
    public $instrument;

    /**
     * Create a new message instance.
     *
     * @param Instrument $instrument
     * @return void
     */
    public function __construct(Instrument $instrument)
    {
        $this->instrument = $instrument;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Instrument Service Request - ' . $this->instrument->name)
            ->markdown('emails.instrument-service-request');
    }
}

