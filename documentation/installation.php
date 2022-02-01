<?php include_once 'include/header.php'; ?>
<main class="container">
    <div class="row">
        <!-- Sidebar -->
        <?php include_once 'include/nav.php';  ?>
        <!-- END Sidebar -->
        <!-- Main content -->
         <!-- Main content -->
        <article class="col-md-9 col-sm-9 main-content" role="main">
          <section>
            <h2 id="installation"><a href="#">Installation</a></h2>
            <p>
              Installation process is very easy and you may finish all process 
              just in 2 minutes. Please read the following guide carefully.
            </p>
            <br>

            <ul class="step-text">
              <li>
                <h5>Upload archive</h5>
                <p>
                  Upload the downloaded zip archive which contains all necessary 
                  files of app to any directory in your web hosting.
                </p>
              </li>

              <li>
                <h5>Extract files</h5>
                <p>
                  Extract all files from archive file to the directory where your 
                  application will be installed. This directory might be  root directory of 
                  your domain (i.e. public_html or www) or any public accessible 
                  subdirectory of any domain.
                </p>
              </li>

              <li>
                <h5>Navigate to installation page</h5>
                <p>
                  Open your web browser and navigate to the directory you’ve 
                  selected in step 2. For example if you’ve extracted the 
                  application files to the root of your domain then you 
                  should navigate to the <strong>yourdomain.com</strong>. When you navigate to 
                  the right directory then page should be redirected to 
                  installation page.
                </p>
              </li>

              <li>
                <h5>Start Installation</h5>
                <p>
                  On installation page click Start Installation using our easy four steps installation wizard.
                </p>
              </li>

                <li>
                    <h5>Admin login information</h5>
                    <p>Add your login information. please remember this information, its your admin panel login info</p>
                    <p>
                        <img src="assets/images/image_1.png" alt="">
                    </p>
                </li>

              <li>
                <h5>Database and Account Details,</h5>
                <p>Then include your database credentials. And setup your main administrative account.</p>
                <div class="text-gray">
                  Please note that you'll not be able to change your database 
                  credentials from account. But you can always 
                  change your administrative account details
                </div>
                  <p>
                      <img src="assets/images/image_2.png" alt="">
                  </p>
              </li>

            <li>
                <h5>Checking Server Requirements</h5>
                <p>Application reequired 7.1 or above</p>
               <p> first please fix issue if any debugged by script at this screen </p>
                  <p>
                      <img src="assets/images/image_3.png" alt="">
                  </p>
            </li>

            <li>
                <h5>Folder Permissions</h5>
                <p>Storage and bootstrap folder permission should be 775</p>
               <p> first assign permission if not assigned</p>
                  <p>
                      <img src="assets/images/image_4.png" alt="">
                  </p>
            </li>

              <li>
                <h5>Finish Installation</h5>

                <p>
                  After filling form on step 5, click finish installation. 
                  If everything is ok, then you should see success 
                  message after few seconds.
                </p>
              </li>
                <p>
                    <img src="assets/images/image_4.png" alt="">
                </p>
            </ul>
          </section>

          <section>
            <h2 id="errors"><a href="#">Errors</a></h2>
            <p>
              During the installation process sometimes you might get an error. 
              Generally detailed description about the error should be displayed.
            </p>

            <p>
              If you're getting <code>Unexpected error occured!</code> then probably
              something is wrong with your server configuration. In this case,
              you should have a look at PHP error log for more information about the error.
            </p>
          </section>
        </article>
         <!-- END Main content -->
       </div>
     </main>


<?php include_once 'include/footer.php'; ?>
 