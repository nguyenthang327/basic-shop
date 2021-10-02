<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gui mail google</title>
</head>
<body>
    <h1>Mail được gửi từ: {{$name}}</h1>
    <h4>Với nội dung: {{$body}}</h4>
    <br>
    <p>Bạn đã đặt những sản phẩm sau</p>
    <ol>
        @foreach($product_names as $product_name)
            <li>
                {{$product_name}}
            </li>
        @endforeach
    </ol>
    <div>
        Tổng tiền: <span class="money">{{$total}}</span>.
    </div>
    <div>
        Chúng tôi sẽ gửi đơn hàng trong vòng 7 ngày.
    </div>
    <br>
    <div>
        Cảm ơn bạn đã đồng hành cùng shop chúng tôi!
    </div>
    
    <script src="{{ asset('fe-assets')}}/js/main.js"></script>
</body>
</html>