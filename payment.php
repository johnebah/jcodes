<?php
require 'php/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Checkout with Redirect</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/checkout/">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
    <script type="text/javascript">
    //generate a random transaction ref
        function setupForm(){
          var merchantCode = 'MX46991';
          var payItemId = 'Default_Payable_MX46991';
          var redirectUri = 'https://qa.interswitchng.com/webpay/Demo/ResponsePage/?';

          document.getElementsByName('txn_ref')[0].value = randomReference();
          document.getElementsByName('merchant_code')[0].value = merchantCode;
          document.getElementsByName('pay_item_id')[0].value = payItemId;
          document.getElementsByName('site_redirect_url')[0].value = redirectUri;
        }

        function randomReference() {
            var length = 10;
            var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            var result = '';
            for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
            return result;
        }


    </script>
</head>

<body class="bg-light" onload="setupForm()">

<div class="container">
    <div class="py-5 text-center">
        <h2>Checkout form</h2>
        <p class="lead">Integrating to Interswitch Payment Gateway - Redirect</p>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill"><?php 
                    if(isset($_SESSION['cart'])){
                        $count = count($_SESSION['cart']);
                        echo $count;
                    }
                ?></span>
            </h4>
            <ul class="list-group mb-3">
               
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0"><?php echo $_POST['course'];?></h6>
                        <small class="text-muted"><?php echo "Jcode.com"; ?></small>
                    </div>
                    <span class="text-muted"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (Naira)</span>
                    <strong>₦<?php 
                        if (isset($_POST['submit'])) {
                           $course = $_POST['course'];
                           $name = $_POST['name'];
                           $email = $_POST['email'];
                           $mobile = $_POST['mobile'];

                           $mysqli = mysqli_query($con,"SELECT * FROM users WHERE email = '$email' ");
                           if (mysqli_num_rows($mysqli)>0) {
                               echo "<script>alert('User with this email already existed')
                               window.location.href = 'index.php#register'
                               </script>";
                           }else{
                           if(!empty($name) && !empty($email) && !empty($mobile)){
                                if ($course == 'Web Design') {
                                   echo "60000";
                                   $id = rand(time(),100000);
                                    $sql = mysqli_query($con,"INSERT INTO users(unique_id,name,email,course,mobile)
                                        VALUES('$id','$name','$email','$course','$mobile');
                                     ");
                                    if ($sql) {
                                          echo "<script>alert('success registered proceed to pay')</script>";
                                     }else{
                                         echo "<script>alert('Oops something went wrong')
                                         window.location.href = 'index.php';
                                         </script>";
                                     }
                                }elseif ($course == "Web Development") {
                                    echo "120000";
                                    $id = rand(time(),100000);
                                    $sql = mysqli_query($con,"INSERT INTO users(unique_id,name,email,course,mobile)
                                        VALUES('$id','$name','$email','$course','$mobile');
                                     ");
                                    if($sql){
                                     echo "<script>alert('success registered proceed to pay ')</script>";
                                     }else{
                                         echo "<script>alert('Oops something went wrong')
                                         window.location.href = 'index.php';
                                         </script>";
                                     }
                                }elseif ($course == "App Development") {
                                   echo "150000";
                                   $id = rand(time(),100000);
                                    $sql = mysqli_query($con,"INSERT INTO users(unique_id,name,email,course,mobile)
                                        VALUES('$id','$name','$email','$course','$mobile');
                                     ");
                                    if($sql){
                                      echo "<script>alert('success registered proceed to pay ')</script>";
                                     }else{
                                          echo "<script>alert('Oops something went wrong')
                                         window.location.href = 'index.php';
                                         </script>";
                                     }
                                }else{
                                    echo "70000";
                                    $id = rand(time(),100000);
                                    $sql = mysqli_query($con,"INSERT INTO users(unique_id,name,email,course,mobile)
                                        VALUES('$id','$name','$email','$course','$mobile');
                                     ");
                                    if($sql){
                                     echo "<script>alert('success registered proceed to pay')</script>";
                                     }else{
                                         echo "<script>alert('Oops something went wrong')
                                         window.location.href = 'index.php';
                                         </script>";
                                     }
                                }
                           }else{
                            echo "<script>alert('Please Input all Fields')
                                window.location.href='index.php#register'
                            </script>";
                           }
                       }
                        }
                    ?></strong>
                </li>
            </ul>
            <!-- <div class="input-group">
                <input type="text" class="form-control" placeholder="Promo code">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Redeem</button>
                </div>
            </div> -->

        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing Information</h4>

          <!-- Form containing POST parameters -->
            <form method='POST' action='https://newwebpay.interswitchng.com/collections/w/pay'>

                <!-- Hidden parameters containing interswitch merchant credentials -->
                <input type="hidden"  name='amount' value="<?php 
                    if(isset($_POST['submit'])){
                        $course = $_POST['course'];
                        if($course == 'Web Design'){
                            echo '6000000';
                        }elseif($course == 'Web Development'){
                            echo '12000000';
                        }elseif($course == 'App Development'){
                            echo '15000000';
                        }else{
                            echo '7000000';
                        }
                    }
                ?>"/>
                <input type="hidden"  name='currency' value="566"/>
                <input type="hidden" name='txn_ref' id="tranRef"/>
                <input type="hidden"  name='merchant_code'/>
                <input type="hidden"  name='pay_item_id'/>
                <input type="hidden"  name='site_redirect_url'/>
                <input type="hidden"  name='display_mode' value='PAGE'/>
                <!-- Hidden parameters end -->

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First Name</label>
                        <input name="" type="email" class="form-control" id="firstName" placeholder="" value="" required>
                        <div class="invalid-feedback">
                            Valid Email is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last Name</label>
                        <input name="" type="text" class="form-control" id="lastName" placeholder="" value="" required>
                        <div class="invalid-feedback">
                            Valid Full Name is required.
                        </div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="email">Student ID <span class="text-muted">(Optional)</span></label>
                    <input name="cust_id" type="num" value="<?php echo $_POST['email']; ?>" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Please enter your valid id.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                    <div class="invalid-feedback">
                        Please enter your address.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>


                <hr class="mb-4">

                <h4 class="mb-3">Payment</h4>
                <hr class="mb-4">
                <button style="border: 1px solid rgb(206, 206, 206);
                height: 40px;
                margin: 0;
                box-shadow: rgb(226, 224, 224) 0px 1px 3px;
                padding: 0 2em 0 0.8em;
                font-weight: 700;
                border-radius: 4px;
                color: rgb(0, 66, 95);
                font-size: 13px;
                text-transform: uppercase;
                background-color: #FFF;
                background-image: url(https://paymentgateway.interswitchgroup.com/paymentgateway/public/images/isw_paynow_btnbg.png);
                width: 260px;
                display: inline-block;
                box-sizing: border-box;
                cursor: pointer;
                font-family: 'proxima-nova', sans-serif, 'Helvetica';">
                    <img style="float:left;" class="isw-pay-logo"
                         src="https://paymentgateway.interswitchgroup.com/paymentgateway/public/images/isw_paynow_btn.png"/>
                    <span style="margin-top: 10px;display: inline-block;margin-left: 8px;">
                        Pay with Interswitch
                    </span>
                </button>
            </form>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2020 Interswitch Group</p>

    </footer>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
</body>
</html>