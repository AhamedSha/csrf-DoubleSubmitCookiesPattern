<?php

    session_start();

    function logout() {

        // unset all cookies and sessions belongs to that user
        unset($_COOKIE['csrf_session_cookie']);
        setcookie('csrf_session_cookie', null, -1, '/');
        unset($_COOKIE['csrf_token_cookie']);
        setcookie('csrf_token_cookie', null, -1, '/');
        unset($_SESSION);

        // redirect to login page
        header("location: ./../login.php");
    }

    function generateCSRFToken($session, $length = 32) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $randomString .= $session[rand(0, strlen($session) - 5)];
        return $randomString;
    }

    if(isset($_POST['logout'])){

        logout();

    } else if (isset($_POST['verify'])){

        // verify the csrf tokens
        if($_POST['csrf_token'] == $_COOKIE['csrf_token_cookie']){
            header("location: ./../display/success.php");
        }else {
            header("location: ./../display/error.php");
        }
    }
?>