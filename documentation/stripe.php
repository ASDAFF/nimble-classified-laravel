<?php include_once 'include/header.php'; ?>
<main class="container">
    <div class="row">
        <!-- Sidebar -->
        <?php include_once 'include/nav.php';  ?>
        <!-- END Sidebar -->
         <!-- Main content -->
        <article class="col-md-9 col-sm-9 main-content" role="main">
          <section>
            <h2 id="overview"><a href="#">Stripe Integration</a></h2>
            <p>
              With built-in Stripe integration, Nimble Ads allows you accept payments from your users for using your website.
              After setting-up Stripe integration, your users ill be available to make a payment with their bank cards
              without leaving your website.
              To enable Stripe integration you just need Stripe Publishable Key and Secret Key.
            </p><br>

            <ul class="text-purple">
              <li>
                  Before trying to configure Stipe integration, make sure 
                  that you're able to accept payment with your Stripe account.
              </li>
            </ul>
              <img src="assets/images/stripe.png" alt="">
          </section>

        </article>
         <!-- END Main content -->
       </div>
     </main>

<?php include_once 'include/footer.php';  ?>


