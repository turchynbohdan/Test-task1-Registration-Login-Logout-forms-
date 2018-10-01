<?php
session_start();
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
  <div class="container">
    <?php
        if(!empty($sessData['userLoggedIn']) && !empty($sessData['userID'])){
            include 'user.php';
            $user = new User();
            $conditions['where'] = array(
                'id' => $sessData['userID'],
            );
            $conditions['return_type'] = 'single';
            $userData = $user->getRows($conditions, userTbl);
    ?>
    <h2>Welcome <?php echo $userData['first_name']; ?>!</h2>
    <a href="userAccount.php?logoutSubmit=1" class="logout">Logout</a>
    <div class="regisFrm">
        <p><b>Name: </b><?php echo $userData['first_name'].' '.$userData['first_name']; ?></p>
        <p><b>Login: </b><?php echo $userData['login']; ?></p>
        <p><b>Birth date: </b><?php echo $userData['birth_date']; ?></p>
        <p><b>Email: </b><?php echo $userData['email']; ?></p>
        <p><b>Country: </b><?php echo $userData['country']; ?></p>
    </div>
    <?php }else{ ?>
    <h2>Login to Your Account</h2>
    <?php echo !empty($statusMsg)?'<p class="'.$statusMsgType.'">'.$statusMsg.'</p>':''; ?>
        <form action="userAccount.php" method="post">
            <label for="login-email" class="form-label">Email</label>
            <input class="form-input-text" type="email" name="email" placeholder="EMAIL" required="">

            <label for="login-password" class="form-label">Password</label>
            <input class="form-input-text" type="password" name="password" placeholder="PASSWORD" required="">

            <div class="send-button">
            <input class="login-button" type="submit" name="loginSubmit" value="LOGIN">
            </div>
        </form>
        <p>Don't have an account? <a href="registration">Register</a></p>
      </div>

    <?php } ?>
</body>
