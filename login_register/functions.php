<?php

function checkUsername ($username) 
{
    if (is_numeric($username))
        return "Username can't be numeric!";
    elseif (strlen($username) < 6 || strlen($username) > 20)
        return "Username must be between 6 and 20 characters long!";
    else
        return "";
}