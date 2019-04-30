<?php
    header("Content-Type: text/html; charset=utf8");
    if(!isset($_POST["submit"])){
    exit("warning");
    }//检测是否有submit操作

    include('config.php');//链接数据库
    $email = $_POST['email'];//post获得用户名表单值
    $password = $_POST['password'];//post获得用户密码单值
    $salt = "62";
    $password_hash = $password . $email . $salt;
    $password_hash = hash('sha256', $password_hash);

    if (($email == '') || ($password_hash == '')) {
        // 若为空,视为未填写,提示错误,并3秒后返回登录界面
        header('refresh:3; url=../login.html');
        echo "用户名或密码不能为空,系统将在3秒后跳转到登录界面,请重新填写登录信息!";
        exit;
    }  else{
        $statement = $pdo->query(
            "SELECT * FROM members WHERE email ='$email' and password = '$password_hash';" );
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            header("refresh:0;url=index.php");//如果成功跳转至首面
            session_start();
            $_SESSION['email']=$email;
            exit;
        } else {
            header('refresh:3; url=../login.html');
            echo "Invalid login or password";
            exit;
        }
    }
?>