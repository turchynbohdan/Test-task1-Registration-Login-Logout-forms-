<?php
session_start();
include 'user.php';
$user = new User();
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}
?>
<head>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

    <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
<div class="container">
  <h2><a href="index">Back</a></p></h2>
  <h2>Create a New Account</h2>
        <form action="userAccount.php" method="post" class="form-app">

            <label for="login-user" class="form-label">Login</label>
            <input id="login-login" class="form-input-text"
            type="text" name="login" placeholder="Login" required="">

            <label for="login-user" class="form-label">First name</label>
            <input id="login-user" class="form-input-text"
            type="text" name="first_name" placeholder="FIRST NAME" required="">

            <label for="login-user" class="form-label">Email</label>
            <input id="login-user" class="form-input-text"
            type="email" name="email" placeholder="EMAIL" required="">

            <label for="login-user" class="form-label">Birth date</label>
            <input id="login-user" class="form-input-text"
            type="date" name="birth_date" placeholder="Birth date" required="">

            <label for="login-user" class="form-label">Password</label>
            <input id="login-user" class="form-input-text"
            type="password" name="password" placeholder="PASSWORD" required="">

            <label for="login-user" class="form-label">Confirm password</label>
            <input id="login-user" class="form-input-text"
            type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required="">

            <label  for="login-user" class="form-label">Country</label>
            <input class="form-input-text"
            list="ice-cream-flavors" id="ice-cream-choice" type="text" name="country" placeholder="Country" required="">
            
            <datalist id="ice-cream-flavors">
              <?php
                $users = $user->getRows('country', countryTbl);
              foreach ($users as $singlepost) {?>
                <option value="<?php echo $singlepost['country'] ?>">
                  <?php } ?>
            </datalist>

            <label for="login-checkbox" class="form-checkbox-label">
              <input id="login-checkbox" class="form-input-checkbox" type="checkbox" name="check" required=""> I agree with terms and conditions
             </label>
            <div class="send-button">
                <input class="login-button" type="submit" name="signupSubmit" value="CREATE ACCOUNT">
            </div>
        </form>
</div>
</body>
