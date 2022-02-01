<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/sweet-alert.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/jquery.js') }}"></script>

    <style>
        body{background: #eeeeee;}
        .well{background: #ffffff; }
        .target{
            border-bottom: 1px solid;
        }
        #logo{ font-size: 50px; margin:  35px 0}
        .m-30{
            margin: 30px;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="well m-t-30">
        <div id="header" class="installation">
            <h1 id="logo" class="text-center">
                RankSol Classified
            </h1>
        </div>
        <div class="content">
            <div class="m-30">
                <div class="jumbotron">
                    <h3 class="target">Welcome</h3>
                    <form action="" method="post">
                        <div class="form-table">
                            <p>All right! All the requirements have met:</p>
                            <ul>
                                <li>PHP >= 7.0.0 <img src="{{asset('assets/images/tick.png')}}" alt=""></li>
                                <li>OpenSSL PHP Extension</li>
                                <li>PDO PHP Extension</li>
                                <li>Mbstring PHP Extension</li>
                                <li>Tokenizer PHP Extension</li>
                                <li>XML PHP Extension</li>
                            </ul>

                        </div>
                        <p class="margin20">
                            <input type="submit" class="button" value="Run the install">
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo "GD: ", extension_loaded('OpenSSL') ? 'OK' : 'MISSING', '<br>';
echo "XML: ", extension_loaded('PDO') ? 'OK' : 'MISSING', '<br>';
echo "zip: ", extension_loaded('Mbstring') ? 'OK' : 'MISSING', '<br>';
echo "zip: ", extension_loaded('Tokenizer') ? 'OK' : 'MISSING', '<br>';
echo "zip: ", extension_loaded('XML') ? 'OK' : 'MISSING', '<br>';
?>

</body>
</html>