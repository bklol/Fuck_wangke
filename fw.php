<?

read(_,_,_);

function read($courseId,$min,$max)
{
    $i = $min;
    while($i <= $max)
    {
        $array[] = "_".$courseId."&id=".$i;
        $i++;
    }
    Fuck_http($array,'1',"");
}

 function Fuck_http($array,$timeout, $cookie)
 {
    $res = array();
    $mh = curl_multi_init();
    foreach($array as $k=>$url)
    {
        $conn[$k]=curl_init($url);
        curl_setopt($conn[$k], CURLOPT_TIMEOUT, $timeout);
        curl_setopt($conn[$k], CURLOPT_HEADER, 0);
        curl_setopt($conn[$k], CURLOPT_RETURNTRANSFER,1);
        curl_setopt($conn[$k], CURLOPT_COOKIE, $cookie);
        curl_multi_add_handle ($mh,$conn[$k]);
    }
     
    do {$mrc = curl_multi_exec($mh,$active);}
    while ($mrc == CURLM_CALL_MULTI_PERFORM);
    while ($active and $mrc == CURLM_OK) 
    {
        if (curl_multi_select($mh) != -1) 
        {
            do {$mrc = curl_multi_exec($mh, $active);} 
            while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
     }
    
     foreach ($array as $k => $url) 
     {
        curl_error($conn[$k]);
        $res[$k] = curl_multi_getcontent($conn[$k]);
        $header[$k] = curl_getinfo($conn[$k]);
        curl_multi_remove_handle($mh , $conn[$k]);
        curl_close($conn[$k]);
     }
    
     curl_multi_close($mh);
 }

?>