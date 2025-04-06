<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 3px solid #5c6bc0;
        }
        .content {
            padding: 20px;
            background-color: #fff;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .order-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            background-color: #5c6bc0;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .status {
            font-weight: bold;
            font-size: 18px;
            color: #5c6bc0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Fandom Emporium</h1>
    </div>
    
    <div class="content">
        <p>Dear {{ $order->user->name }},</p>
        
        <p>We're writing to inform you that the status of your order has been updated.</p>
        
        <div class="order-info">
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
            <p><strong>New Status:</strong> <span class="status">{{ $statusText }}</span></p>
            
            @if($comment)
            <p><strong>Additional Information:</strong> {{ $comment }}</p>
            @endif
        </div>
        
        @if($order->status == 'shipped')
        <p>Your order has been shipped! You should receive your items soon.</p>
        @elseif($order->status == 'in_transit')
        <p>Your order is now in transit and on its way to you!</p>
        @elseif($order->status == 'delivered')
        <p>Your order has been delivered. We hope you enjoy your purchase!</p>
        @elseif($order->status == 'cancelled')
        <p>Your order has been cancelled. If you have any questions, please contact our customer support.</p>
        @else
        <p>Your order is being processed and will be shipped soon.</p>
        @endif
        
        <p>To view your order details, please click the button below:</p>
        
        <a href="{{ route('orders.show', $order->order_number) }}" class="button">View Order</a>
        
        <p>Thank you for shopping with Fandom Emporium!</p>
        
        <p>Best regards,<br>
        The Fandom Emporium Team</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} Fandom Emporium. All rights reserved.</p>
        <p>If you have any questions, please contact our customer service at support@fandomemporium.com</p>
    </div>
</body>
</html> 