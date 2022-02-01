<?php include_once 'include/header.php'; ?>
<main class="container">
    <div class="row">
        <!-- Sidebar -->
        <?php include_once 'include/nav.php';  ?>
        <!-- END Sidebar -->
        <!-- Main content -->
        <article class="col-md-9 col-sm-9 main-content" role="main">
          <section>
            <h2 id="overview"><a href="#">PayPal Integration</a></h2>
            <p>
              With built-in PayPal integration, Nimble Ads allows you accept payments from your users for using your website.
              To enable PayPal integration you just need PayPal API Client ID and Client Secret.
            </p><br>

            <ul class="text-purple">
          

              <li>
                  Before trying to configure PayPal integration, make sure 
                  that you're able to accept payment with your PayPal account.
                  You should have verified Business or Primier account.
              </li>
            </ul>
          </section>
            
          <section>
            <h2 id="installation"><a href="#">Paypal Payment gateway Settings</a></h2>
            <p>Read the following step-by-step guide to learn how to get your PayPal API credentials</p>
              <p>Go to: <a href="https://developer.paypal.com/" target="_blank">PayPal developer center</a></p>
              <ol>
                  <li>To get App credentials, please create account on Paypal from here</li>
                  <li>Make Sure Redirect to Application URL after payment is enabled.</li>
                  <li>Re: Redirect to new URL after payment to validate payment</li>
                  <li>Go to the PayPal website and log in to your account.</li>
                  <li>Click "Profile" at the top of the page.</li>
                  <li>Click the "Website Payment Preferences" link in the Selling Preferences column.</li>
                  <li>Click the Auto Return "On" button.</li>
                  <li>Review the Return URL Requirements.</li>
                  <li>Copy this Url http://yourdomain.com/verify_ad and Enter to the Return URL.</li>
                  <li>Click "Save.</li>
            </ol>
              <br>
              <img src="assets/images/paypal_sttings.png" alt="">

          </section>
        </article>
    </div>
</main>

<?php include_once 'include/footer.php';  ?>