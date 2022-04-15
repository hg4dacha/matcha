<?php



// $object = new stdClass();
// $object->item1 = FALSE;
// $object->item2 = FALSE;
// $object->item3 = FALSE;
// $object->item4 = FALSE;

// if (isset($object->item1))
// {
//     echo "HELLO WORLD!";
// }

$var = FALSE;
$var = htmlspecialchars($var);
if (!$var)
{
    echo "HELLO WORLD!";
}


?>