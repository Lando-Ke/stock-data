<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Contracts\StockServiceInterface;

class StockDataMail extends Mailable
{
    use Queueable, SerializesModels;

    protected StockServiceInterface $stockService;

    public $symbol;
    public $startDate;
    public $endDate;
    public $companyName;

    /**
     * Create a new message instance.
     */
    public function __construct($symbol, $startDate, $endDate)
    {
        $this->stockService = app(StockServiceInterface::class);
        $this->symbol = $symbol;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->companyName = $this->stockService->getCompanyNameBySymbol($symbol);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
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
