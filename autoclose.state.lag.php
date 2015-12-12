<?php 
        $ch = curl_init('http://state.lag/?spacebutton=closespace');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        $output=curl_exec($ch);
        curl_close($ch);
?>
