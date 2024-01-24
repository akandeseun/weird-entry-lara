<html lang="en">

<head>
  <title>Receipt</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="px-2 py-8 max-w-xl mx-auto">
    <div class="flex items-center justify-between mb-8">
      <div class="flex items-center">
        <div class="text-gray-700 font-semibold text-lg">Weird Entry</div>
      </div>
      <div class="text-gray-700">
        <div class="font-bold text-xl mb-2 uppercase">Receipt</div>
        <div class="text-sm">
          Date:
          <?= date('Y-m-d') ?>
        </div>
        <div class="text-sm">
          Order Reference : {{ $order->order_reference }}
        </div>
      </div>
    </div>
    <div class="border-b-2 border-gray-300 pb-8 mb-8">
      <h2 class="text-xl font-bold mb-4">For:</h2>
      <div class="text-gray-700 mb-2">{{ $order->user->first_name }}</div>
      <div class="text-gray-700 mb-2">{{$order->shipping_address}}</div>
      <div class="text-gray-700">{{$order->cart->user_email}}</div>
    </div>
    <table class="w-full text-left mb-8">
      <thead>
        <tr>
          <th class="text-gray-700 font-bold uppercase py-2">Description</th>
          <th class="text-gray-700 font-bold uppercase py-2">Quantity</th>
          <th class="text-gray-700 font-bold uppercase py-2">Price</th>
          <th class="text-gray-700 font-bold uppercase py-2">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->cart->items as $item)
        <tr>
          <td class="py-4 text-gray-700">$item['title']</td>
          <td class="py-4 text-gray-700">$item['quantity']</td>
          <td class="py-4 text-gray-700"><span>&#8358;</span>$item['price']</td>
          <td class="py-4 text-gray-700"><span>&#8358;</span><?= $item['quantity'] * $item['price'] ?></td>
        </tr>
        @endforeach

      </tbody>
    </table>
    <div class="flex justify-end mb-8">
      <div class="text-gray-700 mr-2">Subtotal:</div>
      <div class="text-gray-700"><span>&#8358;</span>{{$order->subtotal}}</div>
    </div>
    <div class="text-right mb-8">
      <div class="text-gray-700 mr-2">Delivery Fee:</div>
      <div class="text-gray-700"><span>&#8358;</span>{{$order->delivery_fee}}</div>
    </div>
    <div class="flex justify-end mb-8">
      <div class="text-gray-700 mr-2">Total:</div>
      <div class="text-gray-700 font-bold text-xl"> <span>&#8358;</span>{{$order->total}}</div>
    </div>
    <div class="border-t-2 border-gray-300 pt-8 mb-8">
      <div class="text-gray-700 mb-2">Thank you for your patronage</div>
      <div class="text-gray-700"> Weird Entry <?= date("Y"); ?> </div>
    </div>
  </div>
</body>

</html>