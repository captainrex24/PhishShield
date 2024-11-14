<?php

function dateFormat($dateString)
{
    $date = new DateTime($dateString);
    return $date->format('F j, Y');
}

function debugQuery($sqlParam = [], $sqlArgs = [], $sqlQuery)
{
    // Create a debug version of the query
    $debugQuery = str_replace(
        $sqlParam,
        $sqlArgs,
        $sqlQuery
    );

    echo "Debug Query: " . $debugQuery;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
