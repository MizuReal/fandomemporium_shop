<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Receipt #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #ddd;
        }
        .receipt-info {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
        }
        .receipt-info div {
            width: 45%;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Receipt</h1>
            <p>Order #{{ $order->order_number }}</p>
            <p>Date: {{ $order->created_at->format('F j, Y') }}</p>
        </div>

        <div class="receipt-info">
            <div>
                <h3>Customer Information</h3>
                <p>
                    <strong>Name:</strong> {{ $order->user->name }}<br>
                    <strong>Email:</strong> {{ $order->user->email }}<br>
                </p>
            </div>
            <div>
                <h3>Shipping Address</h3>
                <p>
                    {{ $order->address->address_line1 }}<br>
                    @if($order->address->address_line2)
                        {{ $order->address->address_line2 }}<br>
                    @endif
                    {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}<br>
                    {{ $order->address->country }}
                </p>
            </div>
        </div>

        <div class="receipt-details">
            <h3>Order Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>PHP {{ number_format($item->price, 2) }}</td>
                        <td class="text-right">PHP {{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                        <td class="text-right">PHP {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total</strong></td>
                        <td class="text-right">PHP {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Thank you for your purchase!</p>
            <p>If you have any questions, please contact our customer support.</p>
        </div>
    </div>
</body>
</html> 