<?php include_once 'include/header.php'; ?>
<main class="container">
    <div class="row">
        <!-- Sidebar -->
        <?php include_once 'include/nav.php';  ?>
        <!-- END Sidebar -->
        <article class="col-md-9 col-sm-9 main-content" role="main">
            <section>
                <h2 id="installation"><a href="#">Featured Ads</a></h2>
                <p>Featured ads help sellers promote their product or service by getting their ads more visibility with more buyers and sell what they want faster
                <p>Featured ads option is fully dynamic, admin have option to active/deactivate featured ads.</p>
                <p>you need to set up cron job for feature ads.</p>
                <p><strong>There are two payment gateways, at a time admin can set only one.</strong></p>
                <ol class="toc">
                    <li><a href="stripe.php">Stripe payment gateway</a></li>
                    <li><a href="paypal.php">Paypal payment gateway</a></li>
                </ol>
                    <p>select any and hit save</p>
                <br>
                <ul class="step-text">
                    <li>
                        <h5>Featured ads settings</h5>
                        <img src="assets/images/feature_ads.png" alt="">
                    </li>
                    <li>
                        <h5>Featured ads, Ads posting</h5>
                        <img src="assets/images/featured_ads_front.png" alt="">
                    </li>
                </ul>
            </section>
        </article>
         <!-- END Main content -->
       </div>
     </main>
<?php include_once 'include/footer.php'; ?>