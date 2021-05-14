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
    // reinitialize session array
    $_SESSION = array();

    // the checkboxes
    $checkboxes = array("This midterm is easy", "I like midterms", "Today is Monday");
    $userChecked = array();

    // if the form has been submitted, add data to session and send user to summary
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(!empty($_POST['boxes'])) {
            // get user input
            $userChecked = $_POST['boxes'];
        }

        if(!empty($_POST['boxes']) && !empty($_POST['name'])) {
            // save the data in the session
            $_SESSION['boxes'] = $_POST['boxes'];
            $_SESSION['name'] = $_POST['name'];
        }
        else{
            $f3->set('errors["nameOrBoxes"]', 'Both name and at least 1 checkbox is required.');
        }

        // if there are no errors, redierct
        if(empty($f3->get('errors'))) {
            header('location: summary');
        }
    }

    // add the user data to the hive
    $f3->set('checkboxes', $checkboxes);
    $f3->set('userChecked', $userChecked);
    $f3->set('name', $_POST['name']);

    // display the page
    $view = new Template();
    echo $view->render('views/survey.html');
});

// summary
$f3->route('GET /summary', function (){
    $_SESSION['boxes'] = implode(", ", $_SESSION['boxes']);

    // display the page
    $view = new Template();
    echo $view->render('views/summary.html');
});

// run Fat-Free
$f3->run();