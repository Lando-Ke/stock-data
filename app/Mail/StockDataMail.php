<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;

class StockDataMail extends Mailable
{
    use Queueable, SerializesModels;

    public $symbol;
    public $startDate;
    public $endDate;
    public $companyName;

    /**
     * Create a new message instance.
     */
    public function __construct($symbol, $startDate, $endDate)
    {
        $this->symbol = $symbol;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->companyName = Company::where('symbol', $this->symbol)->first()->name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $companyName = Company::where('symbol', $this->symbol)->first()->name;
        return new Envelope(
            subject: "{$this->companyName}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.stock_data',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
