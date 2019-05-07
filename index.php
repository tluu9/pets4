<?php
session_start();
//Turn on error reporting
ini_set('display_errors', TRUE);
error_reporting(E_ALL);

//require the autoload file autoload.php
require_once('vendor/autoload.php');
require_once('model/validation-functions.php');

//Create an instance of the Base class/ instantiate Fat-Free
$f3 = Base::instance();

//color array
$f3 -> set('colors', array('pink', 'green', 'blue'));

//food array
$f3 -> set('theFoods', array('bone','veggie','steak','seafood'));

//Turn on Fat-free error reporting/Debugging
$f3->set('DEBUG',3);

//Define a default route (use backlash / )
$f3->route('GET /', function()
{
    //Display a view-set view as new template and echo out the view
    $view = new Template();
    echo $view->render('views/home.html');
});


//Define a route with a parameter
$f3->route('GET /@animal', function($f3, $params) {
    $animal = $params['animal'];

        switch ($animal) {
            case 'dog':
                echo "<h3>Woof!</h3>";
                break;
            case 'cat':
                echo "<h3>Meow</h3>";
                break;
            case 'pig':
                echo "<h3>Oink</h3>";
                break;
            case 'bear':
                echo "<h3>Grrr</h3>";
                break;
            case 'bird':
                echo "<h3>Hello</h3>";
                break;
            default:
                $f3->error(404);
        }
});

//Define a route to display order form 1
$f3->route('GET|POST /order',

    function($f3) {

    $_SESSION = array();

        if(!empty($_POST))
        {
            $animal = $_POST ["animal"];
            $qty = $_POST ["qty"];
            $f3->set('animal',$animal);
            $f3->set('qty',$qty);

            if(form1())
            {
                $_SESSION['animal'] = $animal;
                $_SESSION["qty"] = $qty;
                $f3->reroute("color");
            }
        }
    $view = new Template();
    echo $view->render('views/form1.html');
});

//pick color-Define a route to display order form 2
$f3->route('GET|POST /color',
    function ($f3)
{

    if (!empty($_POST)) {
        $color = $_POST['color'];
        $foods = $_POST['foods'];

        $f3->set('color', $color);
        $f3->set('foods', $foods);

        if (form2()) {
            $_SESSION['color'] = $color;
            $_SESSION['foods'] = $foods;


            $f3->reroute('/summary');
        }

    }
        $view=new Template();
    echo $view->render( 'views/form2.html');
});

$f3->route('GET|POST /summary', function() {

    $view = new Template();
    echo $view->render('views/results.html');
});

//Run fat free F3
$f3->run();
