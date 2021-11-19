<?php

require "./controller/blogController.php";

if(isset($_GET['p'])) {
    switch ($_GET['p']){
        case "blog":
            blog();
            break;
        default :
            home();
            break;
    }
}else{
    home();
}