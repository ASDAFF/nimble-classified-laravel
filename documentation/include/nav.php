<?php
$display = 'style="display: block"';
$settig_active =  $user_panel_active = $create_ad_active = '';
if(PAGE_NAME == 'mail-settings' || PAGE_NAME == 'add-custom-fields' || PAGE_NAME == 'application-settings' || PAGE_NAME == 'cron-jobs' || PAGE_NAME == 'adsense-settings' || PAGE_NAME == 'add-region' || PAGE_NAME == 'add-city' || PAGE_NAME == 'add-category' || PAGE_NAME == 'fields' || PAGE_NAME == 'add-groups' || PAGE_NAME == 'change-theme' || PAGE_NAME == 'admin-profile' || PAGE_NAME == 'featured-ads' || PAGE_NAME == 'mobile-verification' ){
    $settig_active = $display;
}
if(PAGE_NAME == 'user-dashboard' || PAGE_NAME == 'user-active-ads' || PAGE_NAME == 'user-inactive-ads' || PAGE_NAME == 'user-pending-ads'){
    $user_panel_active = $display;
}
if(PAGE_NAME == 'create-ad-details' || PAGE_NAME == 'create-ad-image' || PAGE_NAME == 'create-ad-image' || PAGE_NAME == 'create-verification' || PAGE_NAME == 'create-location' || PAGE_NAME == 'create-ad-payments' ){
    $create_ad_active = $display;
}
?>
<aside class="col-md-3 col-sm-3 sidebar">
    <ul class="sidenav dropable sticky">
        <li><a class="<?= PAGE_NAME == 'index' ? 'active' : ''  ?>" href="index.php">Overview </a></li>
        <li>
            <a class="has-child open">Installation </a>
            <ul>
                <li><a class="<?= PAGE_NAME == 'database_creation' ? 'active' : ''  ?>" href="database_creation.php">Database creation </a></li>
                <li><a class="<?= PAGE_NAME == 'installation' ? 'active' : ''  ?>" href="installation.php">Installation </a></li>
            </ul>
        </li>
        <li>
            <a class="has-child">Settings </a>
            <ul <?= $settig_active ?>>
                <li><a class="<?= PAGE_NAME == 'mail-settings' ? 'active' : ''  ?>" href="mail-settings.php">Mail settings </a></li>
                <li><a class="<?= PAGE_NAME == 'application-settings' ? 'active' : ''  ?>" href="application-settings.php">Application settings </a></li>
                <li><a class="<?= PAGE_NAME == 'cron-jobs' ? 'active' : ''  ?>" href="cron-jobs.php">Cron jobs </a></li>
                <li><a class="<?= PAGE_NAME == 'adsense-settings' ? 'active' : ''  ?>" href="adsense-settings.php">Adsense settings </a></li>
                <li><a class="<?= PAGE_NAME == 'add-region' ? 'active' : ''  ?>" href="add-region.php">Region/states </a></li>
                <li><a class="<?= PAGE_NAME == 'add-city' ? 'active' : '' ?>" href="add-city.php">City </a></li>
                <li><a class="<?= PAGE_NAME == 'add-category' ? 'active' : ''  ?>" href="add-category.php">Category </a></li>
                <li><a class="<?= PAGE_NAME == 'add-custom-fields' ? 'active' : ''  ?>" href="add-custom-fields.php">Custom fields </a></li>
                <li><a class="<?= PAGE_NAME == 'add-groups' ? 'active' : ''  ?>" href="add-groups.php">Groups </a></li>
                <li><a class="<?= PAGE_NAME == 'change-theme' ? 'active' : ''  ?>" href="change-theme.php">Change theme </a></li>
                <li><a class="<?= PAGE_NAME == 'admin-profile' ? 'active' : ''  ?>" href="admin-profile.php">Admin profile </a></li>
                <li><a class="<?= PAGE_NAME == 'featured-ads' ? 'active' : ''  ?>" href="featured-ads.php">Featured ads</a></li>
                <li><a class="<?= PAGE_NAME == 'mobile-verification' ? 'active' : ''  ?>" href="mobile-verification.php">Mobile verification</a></li>
            </ul>
        </li>

        <li><a class="<?= PAGE_NAME == 'admin-dashboard' ? 'active' : ''  ?>" href="admin-dashboard.php">Admin dashboard </a></li>
        <li><a class="<?= PAGE_NAME == 'add-pages' ? 'active' : ''  ?>" href="add-pages.php">Custom pages </a></li>
        <li><a class="<?= PAGE_NAME == 'ads-management' ? 'active' : ''  ?>" href="ads-management.php">Ads management </a></li>
        <li><a class="<?= PAGE_NAME == 'user-management' ? 'active' : ''  ?>" href="user-management.php">User management </a></li>
        <li><a class="<?= PAGE_NAME == 'user-ads' ? 'active' : ''  ?>" href="user-ads.php">User ads </a></li>
        <li>
            <a class="has-child">User Panel </a>
            <ul <?= $user_panel_active ?>>
                <li><a class="<?= PAGE_NAME == 'user-dashboard' ? 'active' : ''  ?>" href="user-dashboard.php">User dashboard </a></li>
                <li><a class="<?= PAGE_NAME == 'user-active-ads' ? 'active' : ''  ?>" href="user-active-ads.php">User active ads </a></li>
                <li><a class="<?= PAGE_NAME == 'user-inactive-ads' ? 'active' : ''  ?>" href="user-inactive-ads.php">User inactive ads </a></li>
                <li><a class="<?= PAGE_NAME == 'user-pending-ads' ? 'active' : ''  ?>" href="user-pending-ads.php">User pending ads </a></li>
            </ul>
        </li>

        <li><a class="<?= PAGE_NAME == 'home-page' ? 'active' : ''  ?>" href="home-page.php">Home page</a></li>
        <li><a class="<?= PAGE_NAME == 'ad-listings' ? 'active' : ''  ?>" href="ad-listings.php">Ad listings</a></li>
        <li><a class="<?= PAGE_NAME == 'ads-detail' ? 'active' : ''  ?>" href="ads-detail.php">Ad's detail</a></li>
        <li><a class="<?= PAGE_NAME == 'map-listings' ? 'active' : ''  ?>" href="map-listings.php">Map listings</a></li>
        <li><a class="<?= PAGE_NAME == 'chat' ? 'active' : ''  ?>" href="chat.php">Chat system</a></li>
        <li><a class="<?= PAGE_NAME == 'message-system' ? 'active' : ''  ?>" href="message-system.php">Message system</a></li>
        <li><a class="<?= PAGE_NAME == 'login' ? 'active' : ''  ?>" href="login.php">Login</a></li>
        <li><a class="<?= PAGE_NAME == 'signup' ? 'active' : ''  ?>" href="signup.php">Register/sign up</a></li>

        <li>
            <a class="has-child " href="#">Create Ad </a>
            <ul <?= $create_ad_active ?>>
                <li><a class="<?= PAGE_NAME == 'create-ad-details' ? 'active' : ''  ?>" href="create-ad-details.php">Description</a></li>
                <li><a class="<?= PAGE_NAME == 'create-ad-image' ? 'active' : ''  ?>" href="create-ad-image.php">Images</a></li>
                <li><a class="<?= PAGE_NAME == 'create-verification' ? 'active' : ''  ?>" href="create-verification.php">Verification</a></li>
                <li><a class="<?= PAGE_NAME == 'create-location' ? 'active' : ''  ?>" href="create-location.php">Location</a></li>
                <li><a class="<?= PAGE_NAME == 'create-ad-payments' ? 'active' : ''  ?>" href="create-ad-payments.php">Payments</a></li>
            </ul>
        </li>

        <li><a class="<?= PAGE_NAME == 'v1.17' ? 'active' : ''  ?>" href="v1.17.php">Changes in version 1.17</a></li>


    </ul>
</aside>