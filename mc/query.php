<!DOCTYPE html>
<html>
    <head>
        <title>query | mwt</title>
        <meta charset="utf-8">
        <link rel="icon" href="/images/favicon.png" type="image/png">
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>
        <h2><img src="/images/favicon.png"> mc / query</h2>
        <?php
        $ip = $_GET["address"];
        $port = $_GET["port"];
        ?>
        <form action="query.php" method="get" id="form">
            Address: <input type="text" name="address" value="<?php echo $ip; ?>"><br>
            Port: <input type="number" name="port" min="1" max="65535" value="<?php echo $port; ?>"><br>
            <input type="submit" value="Check">
        </form>
        <div id="result">
            <?php
            require "../assets/php/MinecraftQuery.php";
            require "../assets/php/MinecraftQueryException.php";
            if(!empty($ip) and !empty($port)){
                $query = new MinecraftQuery();
                try{
                    $query->connect($ip, $port);
                    echo "<h2>Info:</h2>";
                    $info = $query->getInfo();
                    echo <<<INFO
Hostname: {$info["hostname"]}<br>
Host IP: {$info["hostip"]}<br>
Host port: {$info["hostport"]}<br>
Version: {$info["version"]}<br>
Engine: {$info["server_engine"]}<br>
Gametype: {$info["gametype"]}<br>
Game ID: {$info["game_id"]}<br>
Map: {$info["map"]}<br>
Players: {$info["numplayers"]}/{$info["maxplayers"]}<br>
INFO;
                    $plugins = $info["plugins"];
                    sort($plugins);
                    echo "<h2>Plugins (" . count($plugins) . "):</h2><ul>";
                    foreach($plugins as $plugin){
                        echo "<li>$plugin</li>";
                    }
                    echo "</ul>";
                    $players = $query->getPlayers();
                    sort($players);
                    echo "<h2>Players (" . count($players) . "):</h2><ul>";
                    foreach($players as $player){
                        echo "<li>$player</li>";
                    }
                    echo "</ul>";
                }
                catch(MinecraftQueryException $exception){
                    echo "<p class='error'>" . $exception->getMessage() . "</p>";
                }
            }
            else{
                echo "<p class='error'>No address and/or port specified.</p>";
            }
            ?>
        </div>
    </body>
</html>