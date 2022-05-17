<?php


function getFilteredUsers($userid, $minAge, $maxAge, $minPop, $maxPop, $minGap, $maxGap, $minTag, $maxTag)
{
    if ( is_numeric($minAge) && is_numeric($maxAge) && is_numeric($minPop) && is_numeric($maxPop) &&
         is_numeric($minGap) && is_numeric($maxGap) && is_numeric($minTag) && is_numeric($maxTag) )
    {
        echo "ALL OK!";
    }
    else
    {
        http_response_code(400);
    }
}


?>