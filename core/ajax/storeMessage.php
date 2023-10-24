<?php
    include '../init.php';

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST)){
            $message = $_POST['message'];
            $type    = $_POST['type'];
            $botID   = $_POST['botID'];

            $bot     = $chatObj->getBot($botID);

            if($bot)
            {
                $chatObj->storeMessages($message, $type, $bot->ID);
            }
        }
    }
?>