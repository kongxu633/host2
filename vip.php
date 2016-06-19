<?php

/*

调用方式：vip.php?ckid=http://www.iqiyi.com/v_19rrl2o4ag.html


调用方式：vip.php?cmpid=http://www.iqiyi.com/v_19rrl2o4ag.html


注释：没写清晰度~


*/

    error_reporting(0);

    header('Content-Type:text/html;charset=UTF-8');

    $cmpid = isset($_GET['cmpid'])?$_GET['cmpid']:'';
    $ckid = isset($_GET['ckid'])?$_GET['ckid']:'';


    //
    //1465280914
    //2442134



    // 1465281000 2016/6/7 14:30:00 2442135
    // 1465281600 2016/6/7 14:40:00 2442136
    /*
    for ($i=1465280914; $i < 1465280914+2000; $i++) {
        # code...
        echo $i , '-' , date("Y-m-d H:m:s",$i) , '-' , floor(doubleval($i)/600.0) , '<br/>';
    }
    */


    //2016/6/7 14:39:35
    //1465281575@2442135@)(*&^flash@#$%a@d7fb8db8a68c1fab49aaf7b6038fd865
    //http://data.video.qiyi.com/201c7c9825701270ac6f8101a177e730/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v?su={A32F29E1-596B-407E-8D0B-6E5EFFB96538}&qyid={7FACAD69-A6B2-4467-A979-B37057ED51E2}&tn=369

    //2016/6/7 14:40:41
    //1465281641@2442136@)(*&^flash@#$%a@d7fb8db8a68c1fab49aaf7b6038fd865
    //http://data.video.qiyi.com/cf77f85185e363f628b78d571391b7d1/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v?su={EFF5597F-FA3E-4D48-85BF-CA454697D5EB}&qyid={E20CE346-62B4-402C-8E77-31B65DD3720E}&tn=8412


    // 当前时间
    /*
    $i = time();
    echo md5(floor(doubleval($i)/600.0).')(*&^flash@#$%a'.'d7fb8db8a68c1fab49aaf7b6038fd865');
    echo '<hr>';

    $t = 1465281600;    //2016/6/7 14:40:00

    $t = time() - 1800;

    for ($i=$t; $i < $t + 7200; $i+=600) {
        # code...
        $key = md5(floor(doubleval($i)/600.0).')(*&^flash@#$%a'.'d7fb8db8a68c1fab49aaf7b6038fd865');


        echo 'http://data.video.qiyi.com/',$key,'/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v';
        echo '<br/>';
    }
    */

    //8ccdf7f9a75218b3905aa8b5e95d4a41 当前时间算到的KEY
    //http://data.video.qiyi.com/5b7f6a7da79444980329ef7d43ed7fdc/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/201c7c9825701270ac6f8101a177e730/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/cf77f85185e363f628b78d571391b7d1/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v 有效
    //http://data.video.qiyi.com/8ccdf7f9a75218b3905aa8b5e95d4a41/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v 有效
    //http://data.video.qiyi.com/8e56e2a22ba4529bd3734baf4b651d38/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v 有效
    //http://data.video.qiyi.com/1a938c3889dd13dbc5f640516a048f75/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/e092b8de506df61ba7b8eabd08494811/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/2dd9bd9a0d601f14c2fe7ccab2e7f9f9/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/02230f798c5aaf745390c540b92f1d0f/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/264e4f6664ad09d082178704817d6d27/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/90e356a0ca6a6b82e635581f504f1f16/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
    //http://data.video.qiyi.com/9dcc93839832b248cee93df0d8414bab/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v

    //die();

    $ckid = 'http://www.iqiyi.com/v_19rrldv28w.html';//vip

    //$ckid = 'http://www.iqiyi.com/v_19rrlsltj4.html';

    $sysary = array(

        '奇艺VIP',
        'http://www.iqiyi.com',

        'http://www.baidu.com/404.mp4'
    );
    if($cmpid != '' || $ckid != ''){



        $url = $cmpid.$ckid;
        $strs = explode('_',$url);
        $vid = '';
        $proxy = '';
        $xmlt = 0;
        $isOk = false;
        $iqiyiary = array(false);


        if(strpos($url,'iqiyi.com')>-1){

            $content = file_get_contents($url);
            preg_match('/tvId:(.*?),/',$content,$preg);
            //print_r($preg)//Array ( [0] => tvId:443100900, [1] => 443100900 )
            $vid = trim($preg[1]);
            $proxy = 'iqiyi';
            preg_match('/data-player-ismember="(.*?)"/',$content,$preg);
            //print_r($preg);//Array ( [0] => data-player-ismember="false" [1] => false )
            if($preg[1] == 'true') {$iqiyiary[0] = true;}
            preg_match('/data-player-albumid="(.*?)"/',$content,$preg);
            //print_r($preg);//Array ( [0] => data-player-albumid="443100900" [1] => 443100900 )
            $iqiyiary[1] = $preg[1];
            preg_match('/data-player-videoid="(.*?)"/',$content,$preg);
            //print_r($preg);//Array ( [0] => data-player-videoid="5f3044d9fbd791e34016e1bef7a54c36" [1] => 5f3044d9fbd791e34016e1bef7a54c36 )
            $iqiyiary[2] = $preg[1];


        /*
        echo $vid;//484470700
        echo $proxy;//iqiyi
        echo $xmlt;//0
        echo $isOk;//false
        print_r($iqiyiary);//Array ( [0] => [1] => 203966401 [2] => c3e92f2c011d8227ef45d0a846f25415 )
        die();
        */

        }else if($strs[1] == 'iqiyi'){
            $vid = $strs[0];
            $proxy = 'iqiyi';
            $isOk = true;
        }

        if($cmpid != '')
            $xmlt = 1;
        if($ckid != '')
            $xmlt = 2;

        if($proxy == 'iqiyi'){
            $ary = array();
            $ary2 = array();
            $ary3 = array();
            $ary4 = array();
            if($iqiyiary[0]){
                //echo "this is a vip url... <br/>";
                //die();
                $vipcookie = 'P00001=8b8DbBtSRQ3vb1m1H7yE72RDhtMdGAm1SawrlQa3N39vyrwu1ZPBVORdfZm3XMDm2HkRm1594; Domain=.iqiyi.com; Expires=Sat, 17-Sep-2016 06:11:46 GMT; Path=/';
                $ut = time().rand(100,999);
                $utt = ($ut % 1000 * intval(substr($ut,0,2)) + (100 + 0));
                $uuid = uuid();
                $hash = md5($iqiyiary[1].'_afbe8fd3d73448c9_'.$iqiyiary[2].'_'.$ut.'_'.$utt.'_'.intval(0 ^ 2391461978));
                $url = 'http://serv.vip.iqiyi.com/services/ck.action?ut='.$ut.'&vid='.$iqiyiary[2].'&cid=afbe8fd3d73448c9&aid='.$iqiyiary[1].'&utt='.$utt.'&v='.$hash.'&version=1%2E0&platform=b6c13e26323c537d&uuid='.$uuid.'&playType=main';
                $content = getUrlContent($url,$vipcookie);

                /* 错误登录,提示:{"previewTime":6,"previewType":"1","code":"Q00304","msg":"非法用户"}*/
                //echo $url;
                //echo "<br/>";
                //echo $content;
                //die();
                
                $json = json_decode($content,true);
                $keys = $json['data']['t'];
                $us = $json['data']['u'];
                $content = file_get_contents('http://cache.vip.qiyi.com/np/'.$vid.'/'.$iqiyiary[2].'/afbe8fd3d73448c9/'.$keys.'/'.$us.'/');
                $content = stripslashes(DecodeBytesV1(getBytes($content)));
                preg_match('/"vs":(.*?),"vsext"/',$content,$preg);
                $json = json_decode($preg[1],true);
                foreach($json as $key => $val){
                    $ary4[] = $key;
                }
                $gqd = $ary4[0];
                if($isOk == true && $strs[2] != ''){
                    $gqd = $strs[2];
                }
                foreach($json[$gqd]['fs'] as $key=>$val){
                    $ary2[] = $val['s'];
                    $ary3[] = $val['b'];
                    $url = 'http://sf.video.qiyi.com/videos'.$val['l'].'?t='.$keys.'&cid=afbe8fd3d73448c9&vid='.$iqiyiary[2].'&QY00001='.$us.'&start='.$val['s'].'&su='.$uuid.'&client=&z=&mi=tv_415535900_415535900_'.$json[$gqd]['fid'].'&bt=&ct=&e=&tn='.time();
                    $content = file_get_contents($url);
                    $jsons = json_decode($content,true);
                    /*$tary = array(
                        'tvid'=>$vid,
                        'albumid'=>$iqiyiary[1],
                        'videoid'=>$iqiyiary[2],
                        'gqd'=>$gqd,
                        'fd'=>$key
                    );传递保留*/
                    $url = str_replace("\n",'',preg_replace('/http:\/\/.+\/videos\//is','http://wgdcdn.inter.qiyi.com/videos/',$jsons['l']));
                    preg_match('/http:\/\/(.*?)&src=iqiyi.com/',$url,$preg);
                    $ary[] = 'http://'.$preg[1];
                    //$ary[] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?qiyi='.str_replace('=','',base64_encode($url));
                }
                for($i = 0;$i < count($ary2);$i++){
                    $ary2[$i] = (($i == count($ary2) - 1)?($json[$gqd]['duration']*1000 - $ary2[$i]):($ary2[$i + 1] - $ary2[$i]))/1000;
                }
            }else{
                echo "this is not a vip only url... <br/>";
                //can be omitted? tvId and vid are got ahead
                $content = file_get_contents('http://mixer.video.iqiyi.com/jp/mixin/videos/'.$vid);
                $json = json_decode(str_replace('var tvInfoJs=','',$content),true);
                $videoid = $json['vid'];//c3e92f2c011d8227ef45d0a846f25415
                $tvid = $json['tvId'];//484470700
                $uuid = uuid();
                //echo $videoid,'@',$tvid,'@',$uuid,'<br/>';
                //c3e92f2c011d8227ef45d0a846f25415@484470700@{4C9C3B8D-7EC4-4421-890D-BF687C8B50FF}
                //die();
                $content = getUrlContent('http://cache.video.qiyi.com/vp/'.$tvid.'/'.$videoid.'/');
                //echo 'http://cache.video.qiyi.com/vp/'.$tvid.'/'.$videoid.'/';
                //http://cache.video.qiyi.com/vp/484470700/c3e92f2c011d8227ef45d0a846f25415/
                //die();
                $json = json_decode($content,true);
                foreach($json['tkl'][0]['vs'] as $key => $val){
                    $ary4[] = $key;
                }
                $gqd = $ary4[0];

                //print_r($json['tkl'][0]['vs']);
                //print_r($ary4);
                //echo $gqd;
                //die();

                if($isOk == true && $strs[2] != ''){
                    $gqd = $strs[2];
                }
                foreach($json['tkl'][0]['vs'][$gqd]['fs'] as $key=>$val){
                    $Link = $val['l'];
                    if(strstr($val['l'],'-',true) != ''){
                        $Link = GetQiyLink($val['l']);
                        //echo $val['l'];
                        //echo $Link;
                        //  11-7c-1f-49-7d-4f-5f-2c-1f-5f-7b-49-51-2a-4e-1-29-18-5e-7c-1b-6-2e-48-4-70-4f-6-70-1b-3-70-1b-1-7f-1d-48-2b-4c-48-29-1d-48-78-4a-52-78-4f-56-78-4b-48-78-f-48
                        //  /v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v
                        //die();
                    }
                    $Size = $val['b'];
                    $Length = $val['s'];
                    $t = time();
                    preg_match_all('/\/([a-z0-9]*).f4v/',$Link,$Links);
                    $linkHash = floor(doubleval($t)/600.0).')(*&^flash@#$%a'.$Links[1][0];

                    echo $t,'@',floor(doubleval($t)/600.0),'@',')(*&^flash@#$%a','@',$Links[1][0],'<br/>';
                    //1465268530@2442114@)(*&^flash@#$%a@d7fb8db8a68c1fab49aaf7b6038fd865
                    //echo $linkHash;

                    $dispathKey = md5($linkHash);

                    //echo $dispathKey;
                    //abaec94ac9ab3259c73cbb39157bad75

                    $url = 'http://data.video.qiyi.com/'.strtolower($dispathKey).'/videos'.$Link.'?su='.$uuid.'&qyid='.uuid().'&tn='.rand();

                    echo $url;
                    //http://data.video.qiyi.com/abaec94ac9ab3259c73cbb39157bad75/videos/v0/20160530/da/5c/d7fb8db8a68c1fab49aaf7b6038fd865.f4v?su={EF3772C2-909B-40DE-B719-90CF21FA5007}&qyid={BB4C629C-7278-4591-94C5-BEDC4988FD50}&tn=9216
                    die();

                    $cts = file_get_contents($url);
                    $jsons = json_decode($cts,true);
                    $ary[] = preg_replace('/http:\/\/.+\/videos\//is','http://wgdcdn.inter.qiyi.com/videos/',$jsons['l']);
                    $ary2[] = $Length;
                    $ary3[] = $Size;
                }
                for($i = 0;$i < count($ary2);$i++){
                    $ary2[$i] = (($i == count($ary2) - 1)?($json['tkl'][0]['vs'][$gqd]['duration']*1000 - $ary2[$i]):($ary2[$i + 1] - $ary2[$i]))/1000;
                }
            }
        }

        if($xmlt == 1){
            header('Content-Type:text/xml;');
            echo arrayXmlCMP($ary,$ary2,$ary3);
            return;
        }
        if($xmlt == 2){
            header('Content-Type:text/xml;');
            echo arrayXmlCK($ary,$ary2,$ary3,$ary4,$vid,$gqd,$proxy);
            return;
        }
        return;
    }
    if($qiyi != ''){
        $url = base64_decode($qiyi);
        $content = file_get_contents($url);
        $json = json_decode($content,true);
        $url = preg_replace('/http:\/\/.+\/videos\//is','http://wgdcdn.inter.qiyi.com/videos/',$json['l']);
        header('Location: '.$url);
    }
    echo '提示:参数错误!<br />本程序只做学习参考,请勿使用本解析用作商业用途,原创作者将不负任何责任,请合理使用';
    function DecodeBytesV1($param1){
        $loc3 = count($param1);
        $loc5 = 20110218;
        $loc6 = intval($loc5 % 100);
        $loc7 = $loc3 % 4;
        $loc2 = array();
        $loc4 = 0;
        while ($loc4 + 4 <= $loc3)
        {
            $temp = $param1[$loc4] << 24 | $param1[$loc4 + 1] << 16 | $param1[$loc4 + 2] << 8 | $param1[$loc4 + 3];
            $loc8 = $temp < 0 ? intval(4294967295 + $temp + 1) : intval($temp);
            $loc8 = $loc8 ^ intval($loc5);
            $loc8 = rotate_right($loc8, $loc6);
            $loc2[$loc4] = ($loc8 & 4278190080) >> 24;
            $loc2[$loc4 + 1] = ($loc8 & 16711680) >> 16;
            $loc2[$loc4 + 2] = ($loc8 & 65280) >> 8;
            $loc2[$loc4 + 3] = $loc8 & 255;
            $loc4 = $loc4 + 4;
        }
        $loc4 = 0;
        while ($loc4 < $loc7)
        {
            $loc2[$loc3 - $loc7 - 1 + $loc4] = $param1[$loc3 - $loc7 - 1 + $loc4];
            $loc4++;
        }
        return byteToStr($loc2);
    }
    function rotate_right($param1,$param2)
    {
        $param1 = uint($param1);
        $loc4 = 0;
        while ($loc4 < intval($param2))
        {
            $loc3 = $param1 & 1;
            $param1 = $param1 >> 1;
            $loc3 = $loc3 << 31;
            $param1 = $param1 + $loc3;
            $loc4++;
        }
        return $param1;
    }
    function getBytes($string){
        $bytes = array();
        for($i = 0; $i < strlen($string); $i++){
             $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }
    function integerToBytes($val) {
        $byt = array();
        $byt[0] = ($val & 0xff);
        $byt[1] = ($val >> 8 & 0xff);
        $byt[2] = ($val >> 16 & 0xff);
        $byt[3] = ($val >> 24 & 0xff);
        return $byt;
    }
    function byteToStr($bytes){
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
    function urlBin($url){
        global $videoyes;
        $index = -1;
        for($i = 0;$i < count($videoyes);$i++){
            $str = strstr($url,$videoyes[$i],true);
            if($str!='')$index = $i;
        }
        return $index;
    }
    function arrayXmlCMP($ary,$ary2,$ary3){
        global $sysary;
        $str = '<m label="'.$sysary[0].'" version="'.$sysary[1].'" url="'.$sysary[2].'" auth="'.$sysary[3].'" type="2" bg_video="{xywh:[0,0,100P,100P]}">';
        if(count($ary) > 0 && $ary[0] != ''){
            for($i = 0;$i < count($ary);$i++){
                $str .= '<u bytes="'.$ary3[$i].'" duration="'.$ary2[$i].'" src="'.str_replace('&','&amp;',$ary[$i]).'"/>';
            }
        }else{
            $str .= '<u bytes="50429" duration="10" src="'.$sysary[4].'"/>';
        }
        $str .= '</m>';
        return $str;
    }
    function arrayXmlCK($ary,$ary2,$ary3,$ary4,$vid,$gqd,$proxy){
        global $sysary;
        $str = '<ckplayer><plugins><name><![CDATA['.$sysary[0].']]></name><version><![CDATA['.$sysary[1].']]></version><url><![CDATA['.$sysary[2].']]></url><auth><![CDATA['.$sysary[3].']]></auth></plugins>';
        if(count($ary) > 0 && $ary[0] != ''){
            $index = array_search($gqd,$ary4);
            $str .= '<flashvars>{h->'.($index+1).'}{a->'.$vid.'_'.$proxy.'_'.$ary4[$index].'}{defa->';
            for($i = 0;$i < count($ary4);$i++){
                if($i == 0)
                    $str .= $vid.'_'.$proxy.'_'.$ary4[$i];
                else
                    $str .= '|'.$vid.'_'.$proxy.'_'.$ary4[$i];
            }
            $str .= '}{deft->';
            for($i = 0;$i < count($ary4);$i++){
                if($i == 0)
                    $str .= $ary4[$i];
                else
                    $str .= '|'.$ary4[$i];
            }
            $str .= '}{f->http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?ckid=[$pat]}</flashvars>';
            for($i = 0;$i < count($ary);$i++){
                $str .= '<video><file><![CDATA['.str_replace('&amp;','&',$ary[$i]).']]></file></video><seconds>'.$ary2[$i].'</seconds><size>'.$ary3[$i].'</size>';
            }
        }else{
            $str .= '<video><file><![CDATA['.$sysary[4].']]></file><seconds>10</seconds><size>50429</size></video>';
        }
        $str .= '</ckplayer>';
        return $str;
    }
    function getUrlContent($url,$cookie='',$data='',$ref=''){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $header = array();
        if($ref != '')
            $header[] = 'Referer: '.$ref;
        if($cookie != '')
            $header[] = 'Cookie: '.$cookie;
        $header[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.87 Safari/537.36 QQBrowser/9.2.5584.400';
        curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        if($data != ''){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        curl_setopt($ch,CURLOPT_TIMEOUT,3);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }


    function http_status($url) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch,CURLOPT_NOBODY,1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_exec($ch);
        $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $status;
    }
    function uuid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = chr(123).substr($charid, 0, 8).$hyphen.substr($charid, 8, 4).$hyphen.substr($charid,12, 4).$hyphen.substr($charid,16, 4).$hyphen.substr($charid,20,12).chr(125);
            return strtolower(str_replace('-','',str_replace('}','',str_replace('{','',$uuid))));
        }
    }
    function GetQiyLink($strs)
    {
        $loc6 = 0;
        $loc2 = '';
        $loc3 = explode('-',$strs);
        $loc4 = count($loc3);
        $loc5 = $loc4 - 1;
        while($loc5 >= 0)
        {
            $loc6 = uint(GetVrsxorCode(intval($loc3[$loc4 - $loc5 - 1],16),$loc5));
            $loc2 = fromCharCode($loc6).$loc2;
            $loc5--;
        }
        return $loc2;
    }
    function fromCharCode($codes) {
       if (is_scalar($codes)) $codes= func_get_args();
       $str= '';
       foreach ($codes as $code) $str.= chr($code);
       return $str;
    }
    function GetVrsxorCode($strs1,$strs2)
    {
        $strs1 = uint($strs1);
        $strs2 = uint($strs2);
        $loc3 = intval($strs2 % 3);
        if($loc3 == 1)
        {
            return $strs1 ^ 121;
        }
        if($loc3 == 2)
        {
            return $strs1 ^ 72;
        }
        return $strs1 ^ 103;
    }
    function uint($var) {
        if (is_string($var)) {
            if (PHP_INT_MAX > 2147483647) {
                $var = intval($var);
                $var = $var + 1 - abs($var - 4294967295);
            } else {
                $var = floatval($var);
            }
        }
        if (!is_int($var)) {
            $var = intval($var);
        }
        if ((0 > $var) || ($var > 4294967295)) {
            $var &= 4294967295;
            if (0 > $var) {
                $var = sprintf('%u', $var);
            }
        }
        return $var;
    }


?>
