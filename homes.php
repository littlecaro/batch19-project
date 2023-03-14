<?php
    require('./Home.php');

    $littleHouse = new Home();
    $wongHouse = new Home();
    $houseOfHong = new Home();
    $homeOfBahti = new Home();
    $homeOfDionysis = new Home();
    $homeOfMichael = new Home();
    $homeOfScott = new Home();


    $homeOfMichael->openDoor();
    $wongHouse->changeTemperature(40);

?>