<?php

// this is my controller

// turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// start a session
session_start();

// require autoload file
require_once('vendor/autoload.php');

// instantiate Fat-Free
$f3 = Base::instance();

// default route
$f3->route('GET /', function (){
    // display the page
    $view = new Template();
    echo $view->render('views/home.html');
});

// survey
$f3->route('GET|POST /survey', function ($f3){
    // the checkboxes
    $userBoxes = array("This midterm is easy", "I like midterms", "Today is Monday");

    // if the form has been submitted, add data to session and send user to summary
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // save the checked checkboxes in the session
        $_SESSION['boxes'] = $_POST['boxes'];

        header('location: summary');
    }

    // add the user data to the hive
    $f3->set('userBoxes', $userBoxes);

    // display the page
    $view = new Template();
    echo $view->render('views/survey.html');
});

// run Fat-Free
$f3->run();