<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>

<body class="font-sans">
  <div class="max-w-screen-md mx-auto p-4">
    <div class="bg-white p-14 rounded-lg shadow-md">
      <h1 class="text-xl font-bold mb-4">Order Status</h1>

      <p>Hello {{ $order->user->first_name }},</p>

      <p>We are imforming you about a change in your order status</p>

      <p><strong>Order Reference:</strong> {{ $order->order_reference }}</p>
      <p><strong>Order Status:</strong> {{ $order->order_status }}</p>

      <p class="mt-6">Thank you for choosing Weird Entry. If you have any questions or concerns, feel free to contact our customer support.</p>

      <p class="mt-4">Best Regards,<br>{{ config('app.name') }}</p>
    </div>
  </div>
</body>

</html>