<?php include_once 'include/header.php'; ?>
<main class="container">
    <div class="row">
        <!-- Sidebar -->
        <?php include_once 'include/nav.php';  ?>
        <!-- END Sidebar -->
        <article class="col-md-9 col-sm-9 main-content" role="main">
            <section>
                <h2 id="installation"><a href="#">Featured Ads</a></h2>
                <p>Admin can active or deactivate phone verification option. </p>
                <p>Phone number verification verifies users mobile number</p>

                <ul class="step-text">
                    <li>
                        <h5>Twilio Settings</h5>
                        <p> Currently we have setup twilio sms gateway, allow you to send SMS.</p>
                        <img src="assets/images/twilio_settings.png" alt="">
                    </li>
                    <li>
                        <h5>Twilio Number</h5>
                        <p>Select from number to whom you want to send code to users phone number</p>
                        <img src="assets/images/twilio_number.png" alt="">
                    </li>
                    <li>
                        <h5>Phone number verification front view</h5>
                        <img src="assets/images/phone_verification.png" alt="">
                    </li>
                    <li>
                        <h5>Phone number verification tags</h5>
                        <img src="assets/images/verified_phone.png" alt="">
                    </li>
                </ul>
            </section>
        </article>
         <!-- END Main content -->
       </div>
     </main>
<?php include_once 'include/footer.php'; ?>