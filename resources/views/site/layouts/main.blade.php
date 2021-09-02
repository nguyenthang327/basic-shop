<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VNSHOP | @yield('title')</title>

    <!-- LINK BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    

    <!-- reset css -->
    <link rel="stylesheet" href="https://pagecdn.io/lib/normalize/8.0.1/normalize.min.css">

    <!-- font Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!--fontawesome-->
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">


    <!-- LINK CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/font-awesome.min.css" type="text/css"> -->
    <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/base.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/main.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/register_login.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/category.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/product.css" type="text/css">
    <link rel="stylesheet" href="{{ asset('fe-assets') }}/css/payment.css" type="text/css">

    @yield('appendcss')
    

</head>
<body>

    <div class="app">
        <div id="top"></div>
        <!-- HEADER -->
        @include("site.partials.header")
        <!-- END HEADER -->       
    
        <!-- START MAIN -->
        @yield("content")
        <!-- END MAIN -->

        <!-- footer -->
        @include("site.partials.footer")
        <!--End Footer  -->

    
    <!--========== SCROLL REVEAL ==========-->
    <script src="https://unpkg.com/scrollreveal"></script>
   
    <script src="{{ asset('fe-assets')}}/js/main.js"></script>
    
    @yield('appendJS')
    

</body>
</html>