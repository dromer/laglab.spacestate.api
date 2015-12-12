<?php

$key = "secretkey";

function getstate(){
        $json = json_decode(file_get_contents("http://state.laglab.org/spaceapi.json"), true);
        $nowstate = $json['state']['open'];
        $file = fopen("state.txt","w");

        if($nowstate == true){
                $getstate = "open";
        } elseif ($nowstate == false){
                $getstate = "closed";
        }

        fwrite($file, $getstate);
        fclose($file);

        return $getstate;
}

function setstate($do_state){
        global $key;
        $ch = curl_init();
        $setstate = 'https://state.laglab.org/index.php?key='.$key.'&state='.$do_state;
        curl_setopt($ch, CURLOPT_URL, $setstate);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $output=curl_exec($ch);
        curl_close($ch);
}

function displaystate($nowstate){
        echo "<div align=center style='color:#BDBDBD'>";
        if($nowstate == "open" ){
                echo "<img src='open.png'></br>";
                echo "The space is open :]";
        } elseif ($nowstate == "closed"){
                echo "<img src='closed.png'></br>";
                echo "The space is closed :(";
        } else {
                echo "There is something wrong with the spaceapi implementation.</br>
                                Please contact the administrator.";
        }
        echo "</div><br/>";
}

function drawscreen(){
        $nowstate = getstate();

        if ($nowstate == "open"){
                $nextstate = "closespace";
        } elseif ($nowstate == "closed"){
                $nextstate = "openspace";
        }

        echo '
        <!DOCTYPE html>
        <html>
          <head>
            <title>Changing the state!</title>
          </head>
          <body>
        '.displaystate($nowstate).'
        <form method="GET" action="">
        <center><input type="submit" name="spacebutton"  value="'.$nextstate.'"></center>
        </form>
        </body>
        </html>
        ';
}

function writejson($statejson){
        $fp = fopen('state.json', 'w');
        fwrite($fp, json_encode($statejson));
        fclose($fp);
}

$setstate = isset($_GET['spacebutton']) ? $_GET['spacebutton'] : '';

if ($setstate == "openspace"){
        setstate("open");
        drawscreen();
        $statejson = array (
                'state' => 'open'
        );
        writejson($statejson);
} elseif ($setstate == "closespace"){
        setstate("closed");
        drawscreen();
        $statejson = array (
                'state' => 'closed'
        );
        writejson($statejson);
} else {
        drawscreen();
}

?>