<!doctype html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Receipt</title>

  <link rel="stylesheet" href="{{ resource_path('css/receipt.css') }}" type="text/css">
</head>

<body>
  <table class="w-full">
    <tr>
      <td class="w-half">
        <img src="{{ resource_path('images/wentry.png') }}" alt="weird entry" width="200" />
      </td>
      <td class="w-half">
        <h2>Order Reference: {{$order->order_reference}}</h2>
      </td>
    </tr>
  </table>

  <div class="margin-top">
    <table class="w-full">
      <tr>
        <td class="w-half">
          <div>
            <h4>To:</h4>
          </div>
          <div>{{$order->user->first_name}}</div>
          <div>{{$order->shipping_address}}</div>
        </td>
        <td class="w-half">
          <div>
            <h4>From:</h4>
          </div>
          <div>Weird Entry</div>
        </td>
      </tr>
    </table>
  </div>

  <div class="margin-top">
    <table class="products">
      <tr>
        <th>Qty</th>
        <th>Description</th>
        <th>Price</th>
      </tr>
      @foreach($order->cart->items as $item)
      <tr class="items">
        <td>
          {{ $item['quantity'] }}
        </td>
        <td>
          {{ $item['title'] }}
        </td>
        <td>
          {{ $item['price'] }}
        </td>
      </tr>
      @endforeach
    </table>
  </div>

  <div class="total">
    Subtotal: ₦{{$order->subtotal}}
  </div>
  <div class="total">
    Delivery Fee: ₦{{$order->delivery_fee}}
  </div>
  <strong>
    <div class="total">
      Total: ₦{{$order->total}}
    </div>
  </strong>

  <div class="footer margin-top">
    <div>Thank you</div>
    <div>&copy; Weird Entry</div>
  </div>
</body>

</html>