<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    .font-sans {
      font-family: sans-serif;
    }

    .max-w-screen-md {
      max-width: 768px;
      /* Adjust the value based on your design */
    }

    .mx-auto {
      margin-left: auto;
      margin-right: auto;
    }

    .p-4 {
      padding: 1rem;
    }

    .bg-white {
      background-color: #fff;
    }

    .p-14 {
      padding: 3.5rem;
      /* Adjust the value based on your design */
    }

    .rounded-lg {
      border-radius: 0.5rem;
      /* Adjust the value based on your design */
    }

    .shadow-md {
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      /* Adjust the values based on your design */
    }

    .text-xl {
      font-size: 1.25rem;
      /* Adjust the value based on your design */
    }

    .font-bold {
      font-weight: 700;
    }

    .mb-4 {
      margin-bottom: 1rem;
    }

    .mt-4 {
      margin-top: 1rem;
    }

    .mt-6 {
      margin-top: 1.5rem;
      /* Adjust the value based on your design */
    }
  </style>
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

      <p class="mt-6">Thank you for choosing Weird Entry. If you have any questions or concerns, feel free to contact
        our customer support.</p>

      <p class="mt-4">Best Regards,<br>{{ config('app.name') }}</p>
    </div>
  </div>
</body>

</html>