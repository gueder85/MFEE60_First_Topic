<?php

if(isset($_COOKIE["account"])){
    echo $_COOKIE["account"]."<br>";
}
if(isset($_COOKIE["user"])){
    $user=json_decode($_COOKIE["user"]); //轉回成物件
    echo "Hi, ".$user->account.".";
}
