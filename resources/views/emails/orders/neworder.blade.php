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

    /* Additional styles for the second HTML code */

    .bg-blue-500 {
      background-color: #1E40AF;
      /* Adjust the color based on your design */
    }

    .text-white {
      color: #fff;
      /* Adjust the color based on your design */
    }

    .px-4 {
      padding-left: 1rem;
      padding-right: 1rem;
    }

    .py-2 {
      padding-top: 0.5rem;
      padding-bottom: 0.5rem;
    }

    .rounded-md {
      border-radius: 0.375rem;
      /* Adjust the value based on your design */
    }

    .inline-block {
      display: inline-block;
    }
  </style>
  <!-- <title>New Order Alert</title> -->
</head>

<body class="font-sans">
  <div class="max-w-screen-md mx-auto p-4">
    <div class="bg-white p-14 rounded-lg shadow-md">
      <h1 class="text-xl font-bold mb-4">New Order Alert</h1>

      <p>Hello Admin,</p>

      <p>A new order has been placed on the weird entry website Here are the details:</p>

      <p><strong>Order Reference:</strong> {{ $order->order_reference }}</p>
      <p><strong>Customer Name:</strong> {{ $order->user->first_name }}</p>
      <p><strong>Customer Email:</strong> {{ $order->user->email }}</p>
      <p><strong>Order Total:</strong> ${{ $order->total }}</p>

      <div class="mt-4">
        <p><strong>Shipping Address:</strong>{{ $order->shipping_address }}</p>
      </div>

      <div class="mt-4">
        <p><strong>Ordered Items:</strong></p>
        <ul>
          @foreach($order->cart->items as $item)
          <li>{{ $item['title'] }} x {{ $item['quantity'] }} - ${{ $item['price'] }}</li>
          @endforeach
        </ul>
      </div>

      <div class="mt-6">
        <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-md inline-block">View Order</a>
      </div>

    </div>
  </div>
</body>

</html>