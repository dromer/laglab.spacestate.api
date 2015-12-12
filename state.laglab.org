<?php

$thekey = "secretkey";

function displaystate(){
        $file = "spaceapi.json";
        $json = json_decode(file_get_contents($file), true);
        $nowstate = $json['state']['open'];

        echo "<div align=center style='color:#BDBDBD'>";
        if($nowstate == true){
                echo "<img src='open.png'></br>";
                echo "The space is open :]";
        } elseif ($nowstate == false){
                echo "<img src='closed.png'></br>";
                echo "The space is closed :(";
        } else {
                echo "There is something wrong with the spaceapi implementation.</br>
                                Please contact the administrator.";
        }
        echo "</div>";
}

$state = isset($_GET["state"]) ? $_GET["state"] : '';
$key = isset($_GET["key"]) ? $_GET["key"] : '';

if(!empty($state) and $key == $thekey){
        if($state == "open"){
                $newstate = true;
        } elseif ($state == "closed"){
                $newstate = false;
        } else {
                displaystate();
                exit;
        }
} else {
        displaystate();
        exit;
}

$spaceapi = array (
        'api' => '0.13',
        'space' => 'LAG',
        'logo' => 'http://laglab.org/logo.png',
        'url' => 'http://laglab.org',
        'location' => array(
                'address' => 'Eerste Schinkelstraat 16, 1075 TX Amsterdam, The Netherlands',
                'lat' => (float) 52.35406,
                'lon' => (float) 4.85423
        ),
        'contact' => array(
                'irc' => 'irc://irc.indymedia.nl/#lag',
                'email' => 'info@laglab.org'
        ),
        'issue_report_channels' => array(
                'email'
        ),
        'state' => array(
                'open' => $newstate,
                'icon' => array(
                        'open' => 'http://state.laglab.org/open.png',
                        'closed' => 'http://state.laglab.org/closed.png'
                )
        )
);

$fp = fopen('spaceapi.json', 'w');
fwrite($fp, json_encode($spaceapi));
fclose($fp);

$fsnl = fopen('state.html', 'w');
if($newstate == true){
        fwrite($fsnl, '<body style="text-align: center; background-color: #0b0;"> <a href="http://laglab.org" style="text-decoration: none; color: #ff0;">The space is open :]</a> </body>');
} elseif ($newstate == false){
        fwrite($fsnl, '<body style="text-align: center; background-color: #DA1818;"> <a href="http://laglab.org" style="text-decoration: none; color: #ff0;">The space is closed :(</a> </body>');
} else {
        fwrite($fsnl, "b0rk b0rk");
}
fclose($fsnl);

$lagbot = fopen('botstate', 'w');
if($newstate == true){
        fwrite($lagbot, 'open');
} elseif ($newstate == false){
        fwrite($lagbot, 'closed');
} else {
        fwrite($lagbot, "b0rk b0rk");
}
fclose($lagbot);

?>
