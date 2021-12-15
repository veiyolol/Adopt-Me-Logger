<?php
    require("config.php");
    header("Access-Control-Allow-Origin: *");

    // veiyo#0002
    if (isset($_GET["p"])) {
        header("Content-Type: application/javascript");

        if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER["HTTP_ORIGIN"], $allowed_origins)) {
            echo file_get_contents("payload.js");
        } else {
            echo "alert('Bot is under maintenance. Temporarily unavailable.')";
        }

        die();
    }
    
    // respond with instructions page
    echo file_get_contents("./page.html");
?>
