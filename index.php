<?php
// ROUTER

require("./controller/controller.php");

try {
    $action = $_REQUEST['action'] ?? null;

    switch ($action) {
        case "userProfile":
            require('./view/userProfile.php');
            break;
        case "userSignInGoogle":
            $token = $_POST['credential']; //post credentials 
            $decodedToken = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1])))); // decoding the json web token (JWT) into the array info

            checkUserSignInGoogle($decodedToken);
            // require('./view/testView.php');
            break;
        default:
            showIndex();
            break;
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();
    require("./view/errorView.php");
}
