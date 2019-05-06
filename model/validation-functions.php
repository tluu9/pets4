<?php
    /*
     * Validate a color
     *
     * @param String color
     * @return boolean
     */

    function form1()
    {
        global $f3;
        $isValid= true;
        if (!validString($f3->get('animal'))) {
            $isValid = false;
            $f3->set("errors['animal']", "Please enter an animal ");
        }
        if (!validQty($f3->get('qty'))) {
            $isValid = false;
            $f3->set("errors['qty']", "Please enter quantity");
        }
        return $isValid;
    }

function form2()
{
    global $f3;
    $isValid= true;

    if (!validColor($f3->get('color'))) {
        $isValid = false;
        $f3->set("errors['colors']", "Please enter a color.");
    }
    if (!validToys($f3->get('foods'))) {
        $isValid = false;
        $f3->set("errors['foods']", "Please enter food");
    }
    return $isValid;
}

//form1
function validQty($qty)
{
    return ctype_digit($qty) && $qty > 0;
}

function validString($string)
{
    return $string !== "" && !is_numeric($string);
}

//form 2
function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validFoods($foods)
{
    global $f3;
    if (empty($foods))
    {
        return true;
    }

    foreach($foods as $picked)
    {
        if(!in_array($picked, $f3->get('foods')))
        {
            return false;
        }
    }
    return true;
}
