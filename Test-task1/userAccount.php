   <?php
session_start();

include 'user.php';
$user = new User();
if(isset($_POST['signupSubmit'])){
    if(!empty($_POST['login']) && !empty($_POST['check']) && !empty($_POST['first_name']) && !empty($_POST['email']) && !empty($_POST['birth_date']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['country'])){
        if($_POST['password'] !== $_POST['confirm_password']){
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Confirm password must match with the password.';
        }else{
            $checkEmail['where'] = array('email'=>$_POST['email']);
            $checkEmail['return_type'] = 'count';
            $prevUser1 = $user->getRows($checkEmail, userTbl);

            $checkLogin['where'] = array('login'=>$_POST['login']);
            $checkLogin['return_type'] = 'count';
            $prevUser2 = $user->getRows($checkLogin, userTbl);

            if($prevUser1 > 0){
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Email already exists, please use another email.';
            }else if($prevUser2 > 0){
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'login already exists, please use another email.';
            }else{
                $userData = array(
                    'login' => $_POST['login'],
                    'first_name' => $_POST['first_name'],
                    'email' => $_POST['email'],
                    'birth_date' => $_POST['birth_date'],
                    'password' => md5($_POST['password']),
                    'country' => $_POST['country']
                );
                $insert = $user->insert($userData);
                if($insert){
                    $sessData['status']['type'] = 'success';
                    $sessData['status']['msg'] = 'You have registered successfully.';
                }else{
                    $sessData['status']['type'] = 'error';
                    $sessData['status']['msg'] = 'Some problem occurred, please try again.';
                }
            }
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'All fields are mandatory, please fill all the fields.';
    }

    $_SESSION['sessData'] = $sessData;
    $redirectURL = ($sessData['status']['type'] == 'success')?'index.php':'registration.php';
    header("Location:".$redirectURL);
}elseif(isset($_POST['loginSubmit'])){
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $conditions['where'] = array(
            'email' => $_POST['email'],
            'password' => md5($_POST['password']),
            'status' => '1'
        );
        $conditions['return_type'] = 'single';
        $userData = $user->getRows($conditions, userTbl);
        if($userData){
            $sessData['userLoggedIn'] = TRUE;
            $sessData['userID'] = $userData['id'];
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Welcome '.$userData['first_name'].'!';
        }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Wrong email or password, please try again.';
        }
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Enter email and password.';
    }
    $_SESSION['sessData'] = $sessData;
    header("Location:index.php");
}elseif(!empty($_REQUEST['logoutSubmit'])){
    unset($_SESSION['sessData']);
    session_destroy();
    $sessData['status']['type'] = 'success';
    $sessData['status']['msg'] = 'You have logout successfully from your account.';
    $_SESSION['sessData'] = $sessData;
    header("Location:index.php");
}else{
    header("Location:index.php");
}
