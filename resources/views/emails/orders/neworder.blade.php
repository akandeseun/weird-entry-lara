<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
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