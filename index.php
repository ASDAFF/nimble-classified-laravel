<?php
$filename = 'storage/installed';
if (!file_exists($filename)) {
/* check requirements */
$err = array();

if(!version_compare(phpversion(), '7.1.3', '>=')) {
    $err[]= 'Required php version <strong style="color:green">7.1.3</strong> or above. Your current php version is <strong style="color:red"> ' . phpversion() . ' </strong>  please update php version to install nimble classified application.';
}
if(!extension_loaded('openssl'))
{
    $err[]= 'This app needs the <strong style="color:red"> Open SSL </strong> PHP extension.';
}

if(!extension_loaded('pdo'))
{
    $err[]= 'This app needs the <strong style="color:red"> PDO </strong> PHP extension.';
}
if(!extension_loaded('mbstring'))
{
    $err[]= 'This app needs the <strong style="color:red"> Mbstring </strong> PHP extension.';
}
if(!extension_loaded('xml'))
{
    $err[]= 'This app needs the <strong style="color:red"> XML </strong> PHP extension.';
}
if(count($err) > 0) { ?>
    <!DOCTYPE html>
    <html>
    <head>
        <link href="admin_assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="public/installer/css/style.min.css" rel="stylesheet"/>
    </head>
<body>
<body>
<div class="master">
    <div class="box">
        <div class="header">
            <h1 class="header__title"> Laravel Installer
            </h1>
        </div>

        <div class="main">

            <style>
                .box {
                    width: inherit !important;
                }

                .main {
                    padding: 5px 40px 30px !important;
                }

            </style>

            <?php
            echo '<h3> Please Fix following server errors to install Nimble Ads Application </h3>';
            echo '<ol>';
            foreach ($err as $val) {
                echo '<li>' . $val . '</li>';
            }
            echo '</ol>';
            ?>
        </div>
    </div>
</div>
</body>

<?php
exit;
    }

}
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);
// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}
require_once __DIR__ . '/public/index.php';
