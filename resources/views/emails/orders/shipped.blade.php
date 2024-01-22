<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="font-sans">
  <div class="max-w-screen-md mx-auto p-4">
    <div class="bg-white p-14 rounded-lg shadow-md">
      <h1 class="text-xl font-bold mb-4">Order Shipped Notification</h1>

      <p>Hello {{ $order->user->first_name }},</p>

      <p>We are excited to inform you that your order with the following details has been shipped:</p>

      <p><strong>Order Reference:</strong> {{ $order->order_reference }}</p>
      <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
      <p><strong>Estimated Delivery Date:</strong> 5 days</p>

      <div class="mt-4">
        <p><strong>Shipped Items:</strong></p>
        <ul>
          @foreach($order->cart->items as $item)
          <li>{{ $item['title'] }} x {{ $item['quantity'] }}</li>
          @endforeach
        </ul>
      </div>

      <p class="mt-6">You can track your order using the order reference provided.</p>

      <p class="mt-6">Thank you for choosing Weird Entry. If you have any questions or concerns, feel free to contact our customer support.</p>

      <p class="mt-4">Best Regards,<br>{{ config('app.name') }}</p>
    </div>
  </div>
</body>

</html>