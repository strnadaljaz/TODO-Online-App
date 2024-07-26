<?php

$dbhost = "localhost";
$dbuser = "aljaz";
$dbpass = "pCG(VZU-6n5La_A]";
$dbname = "todo";

if (!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
    die("failed to connect");