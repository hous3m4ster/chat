<?php

if(isset($_GET['call'])){
    switch($_GET['call']){
        case 'getid':
            print getUser();
            break;
        case 'msg':
            if(isset($_GET['from']) && isset($_GET['to']) && isset($_GET['user_secret']) && isset($_GET['msg'])){
                //todo
                print "Succes";
            }else {
                print "Error 2: Specify 'from', 'to', 'user_secret' and 'msg' fields in request";
            }
            break;
        default:
            print "Error 1: Specify valid API call.";
    }
}else {
    print "<h1>GoGhost API v0.0.1";
}