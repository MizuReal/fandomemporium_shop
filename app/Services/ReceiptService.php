<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptService
{
    /**
     * Generate a PDF receipt for an order
     * 
     * @param Order $order
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateReceipt(Order $order)
    {
        // Eager load relationships to avoid N+1 queries
        $order->load(['user', 'address', 'orderItems.product']);
        
        // Generate PDF with proper Unicode support
        $pdf = PDF::loadView('emails.order-receipt', compact('order'));
        
        // Set paper and formatting options
        $pdf->setPaper('a4', 'portrait');
        
        // Configure PDF for better Unicode support
        $pdf->getDomPDF()->set_option('defaultFont', 'DejaVu Sans');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        
        return $pdf;
    }
    
    /**
     * Get the filename for the receipt
     * 
     * @param Order $order
     * @return string
     */
    public function getReceiptFilename(Order $order)
    {
        return 'receipt-' . $order->order_number . '.pdf';
    }
} 