<?php

namespace App\Mail;

use App\Models\Order;
use App\Services\ReceiptService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusText;
    public $comment;
    protected $receiptService;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $comment = null)
    {
        $this->order = $order;
        $this->comment = $comment;
        $this->statusText = $this->getStatusText($order->status);
        $this->receiptService = new ReceiptService();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order #' . $this->order->order_number . ' Status Updated: ' . $this->statusText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // If order status is delivered, attach the receipt
        if ($this->order->status === 'delivered') {
            $pdf = $this->receiptService->generateReceipt($this->order);
            $filename = $this->receiptService->getReceiptFilename($this->order);
            
            $attachments[] = Attachment::fromData(fn () => $pdf->output(), $filename)
                ->withMime('application/pdf');
        }
        
        return $attachments;
    }

    /**
     * Get human-readable status text.
     */
    private function getStatusText($status): string
    {
        $statusMap = [
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'in_transit' => 'In Transit',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled'
        ];

        return $statusMap[$status] ?? ucfirst($status);
    }
} 