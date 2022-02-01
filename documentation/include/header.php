<?php
define( 'PAGE_NAME', str_replace('.php','', basename( $_SERVER['PHP_SELF'] ) ) );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <title>Nimble Ads, Complete Classified Application</title>

    <!-- Styles -->
    <link href="./assets/css/plugins.css" rel="stylesheet" />

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:100,300,400,500%7CLato:300,400' rel='stylesheet' type='text/css' />
    <link href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css' />

    <link rel="icon" href="./assets/img/favicon.png" />
</head>

<body>

<header class="site-header navbar-fullwidth navbar-transparent">

    <!-- Top navbar & branding -->
    <nav class="navbar navbar-default navbar-transparent" style="">
        <div class="container">


            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="true" aria-controls="navbar">
                    <span class="glyphicon glyphicon-option-vertical"></span>
                </button>

                <button type="button" class="navbar-toggle for-sidebar" data-toggle="offcanvas">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="assets/images/image_11.png" alt="nimble ads" /></a>
            </div>

            <div id="navbar" class="navbar-collapse collapse" aria-expanded="true" role="banner">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hero"><a href="https://ranksol.com/help" target="_blank"> <i class="fa fa-question"></i> Help</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END Top navbar & branding -->

    <!-- Banner -->
    <?php if(PAGE_NAME == 'index'){ ?>
        <div class="banner banner-lg" style="    background: #fe9400;
    background: -moz-linear-gradient(-45deg, #fe9400 0%, #86269b 100%);
    background: -webkit-gradient(left top, right bottom, color-stop(0%, #fe9400), color-stop(100%, #86269b));
    background: -webkit-linear-gradient(-45deg, #fe9400 0%, #86269b 100%);
    background: -o-linear-gradient(-45deg, #fe9400 0%, #86269b 100%);
    background: -ms-linear-gradient(-45deg, #fe9400 0%, #86269b 100%);
    background: linear-gradient(135deg, #b79a98 0%, #4e269b 100%);
    color: #fff;
    background-position: center;
    background-repeat: no-repeat;
    background-size: auto;
    background-attachment: scroll;">
            <div class="container text-center">
                <h1><strong>Nimble Classified Ads Script</strong><br> PHP And Laravel Geo Classified <br> Advertisement CMS</h1>

                <br /><br /><br /><br />
                <p><a class="btn btn-round btn-white btn-outline" href="#overview" role="button"> Get Started  </a></p>
            </div>

            <ul class="social-icons">
                <li><a href="https://www.facebook.com/RankSol?ref=hl" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/ranksol" target="_blank"><i class="fa fa-twitter"></i></a></li>
            </ul>
        </div>
    <?php }  ?>
    <!-- END Banner -->
</header>