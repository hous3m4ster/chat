<?php


function generateUserID($digit){
    return substr(str_shuffle(str_repeat($x='0123456789',$digit)),0,$digit);
}

function sendMsg($from, $to, $msg) {
    //TODO
}
function getOnline(){
    //TODO online user storage needs to happen with database
    $users = explode("\n", file_get_contents("storage/users.txt"));
    return $users;
}
function getUser(){
    $existing = getOnline();
    $userid = generateUserID(10); //generate 10 digit user id
    $id = $userid;
    $unique = true;

    foreach($existing as $user){
        if($id == $user){
            $unique = false;
        }
    }
    if($unique == true){
        $current = file_get_contents("storage/users.txt") . "\n" . $id;
        file_put_contents("storage/users.txt", $current);
        return $id;

    }else {
        getUser();
    }
}

function sendMessage($from, $to, $user_secret, $message){
    //TODO
    
}