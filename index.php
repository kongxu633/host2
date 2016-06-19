<?php

include "config.php";

class IqiyiIE{
    const IE_NAME = 'iqiyi';
    const IE_DESC = '爱奇艺';
    //last update at 2016-01-22 for Zombie::bite
    const ENC_KEY = '4a1caba4b4465345366f28da7c117d20';

    const _VALID_URL = '/https?:\/\/(?:(?:[^.]+\.)?iqiyi\.com|www\.pps\.tv)/.+\.html/i';

    private $_email  = '';
    private $_passwd = '';
    private $_cookie = '';

    // normal
    // $url = 'http://www.iqiyi.com/v_19rrlsltj4.html';
    // $tvid = '484470700';
    // $video_id = 'c3e92f2c011d8227ef45d0a846f25415';

    // vip
    // $url = 'http://www.iqiyi.com/v_19rrldre6k.html';
    // $tvid = '493221600';
    // $video_id = 'a07d09e307310f394a2fda9e4bdfa642';

    public $_tests = [
        'normal' => [
            'url' => 'http://www.iqiyi.com/v_19rrlsltj4.html',
            'tvid' => '484470700',
            'video_id' => 'c3e92f2c011d8227ef45d0a846f25415',
        ],
        'vip' => [
            'url' => 'http://www.iqiyi.com/v_19rrldre6k.html',
            'tvid' => '493221600',
            'video_id' => 'a07d09e307310f394a2fda9e4bdfa642',
        ],
    ];

    public $_member = 'vip';

    public function __construct($email='',$passwd='')
    {
        $this->_email = $email;
        $this->_passwd = $passwd;
        //echo self::IE_NAME,'-',self::IE_DESC,'-',$this->now(),'<br/>';
    }

    public function now()
    {
        return date('Y-m-d H:i:s',time());
    }

    public function _real_initialize()
    {
        self::_login();
    }

    public function _login()
    {
        $token_url = 'http://kylin.iqiyi.com/get_token';
        $token_str = $this->_cget($token_url);
        
        $timestamp = time();
        $target = '/apis/reglogin/login.action?email='.$this->_email.'&passwd='.$this->_passwd.'&agenttype=1&from=undefined&keeplogin=1&piccode=&fromurl=%23&_pos=1';

        $token_json = json_decode($token_str,True);

        $data_code = $token_json['code'];
        $data_sdk = $token_json['sdk'];
        $data_ip = $token_json['ip'];
        $data_token = $token_json['token'];

        if($data_code == 'A00000'){
            $this->dd($data_code,'token_code');
            $this->dd($data_ip,'token_ip');
            $this->dd($data_token,'token_token');
            $this->dd($timestamp,'timestamp');
        }

        $unpacker = new JavascriptUnpacker;

        $unpack_js =$unpacker->unpack($data_sdk);

        $this->dd($unpack_js,'unpacked js to txt');

        $functions = [];
        if(preg_match_all("/input=([a-zA-Z0-9]+)\(input/",$unpack_js,$matches)){
            $functions = $matches[1];
        }

        $this->dd($functions,'check out the functions');

        $sign = $target;
        foreach($functions as $func){
            $sign = $this->IqiyiSDK($sign, $data_ip, $timestamp, $func);
        }

        $validation_params = [
            'target' => $target,
            'server' => 'BEA3AA1908656AABCCFF76582C4C6660',
            'token' => $data_token,
            'bird_src' => 'eb8d221bc0c04c5ab4ba735b6b1560a1',
            'sign' => $sign,
            'bird_t' => $timestamp,
        ];

        $this->dd($validation_params);

        $validation_url = 'http://kylin.iqiyi.com/validate?' . http_build_query($validation_params);

        $this->dd($validation_url);

        //$validation_result = $this->_cget($validation_url);

        //$this->dd($validation_result);

        $result_cookies = $this->http_cookies($validation_url);

        var_dump($result_cookies);


    }

    public function IqiyiSDK($target,$ip,$timestamp,$func)
    {

        $md5_str = md5($target);
        $ip_arr = explode('.',$ip);
        $time_arr = str_split($timestamp);

        if(preg_match('/mod(\d+)/i',$func,$matches))
        {
            foreach($ip_arr as $v){
                $md5_str .= $v % intval($matches[1]);
            }
            return $md5_str;
        }
        if(preg_match('/date([ymd]{3})/i',$func,$matches))
        {
            $_y = date('Y',$timestamp);
            $_m = date('m',$timestamp);
            $_d = date('d',$timestamp);
            $_r = $matches[1];

            $_r = str_replace(['y','m','d'],[$_y,$_m,$_d],$_r);
            $md5_str .= $_r;

            return $md5_str;
        }
        if(preg_match('/split([458]{1})/i',$func,$matches)){

            $_num = $matches[1];

            $mod_arr = [
                '4' => 256,
                '5' => 10,
                '8' => 100,
            ];

            $tmp = preg_replace('/(\w{'.$_num.'})/i','$1#',$md5_str,4);
            $tmp_arr = explode('#',$tmp);

            $_r = '';
            for($i=0;$i<4;$i++){
                if($_num > 5 || $_num == 8){
                    $_r .= $ip_arr[$i] % $mod_arr[$_num] . $tmp_arr[$i];
                }else {
                    $_r .= $tmp_arr[$i] . $ip_arr[$i] % $mod_arr[$_num];
                }
            }
            $_r .= $tmp_arr[4];

            return $_r;
        }
        if($func == 'handleInput8'){
            $arr = str_split($md5_str,8);
            $tmp = '';
            foreach($arr as $v){
                $sum = 0;
                for($i=0;$i<8;$i++){
                    $sum += hexdec($v[$i]);
                }
                $tmp .= $sum . $v;
            }
            return $tmp;
        }
        if($func == 'handleInput16'){
            $arr = str_split($md5_str,16);

            $sum = 0;
            for($i=0;$i<16;$i++){
                $sum += hexdec($arr[0][$i]);
            }

            $tmp = $sum . $md5_str;

            $sum = 0;
            for($i=0;$i<16;$i++){
                $sum += hexdec($arr[1][$i]);
            }

            $tmp = $tmp . $sum;

            return $tmp;
        }
        if($func == 'splitTimeOddEven'){
            $o_sum = $e_sum = 0;
            for($i=0;$i<10;$i++){
                $i % 2 == 0 ? $o_sum += $time_arr[$i] : $e_sum += $time_arr[$i];
            }
            return $o_sum . $md5_str . $e_sum;
        }
        if($func == 'splitTimeEvenOdd'){
            $o_sum = $e_sum = 0;
            for($i=0;$i<10;$i++){
                $i % 2 == 0 ? $o_sum += $time_arr[$i] : $e_sum += $time_arr[$i];
            }
            return $e_sum . $md5_str . $o_sum;
        }
        if($func == 'handleSum'){
            $sum = 0;
            for($i=0;$i<32;$i++){
                $sum += hexdec($md5_str[$i]);
            }
            return $sum . $md5_str;
        }
        if($func == 'splitTimeIpSum'){
            $ip_sum = array_sum($ip_arr);
            $time_sum = array_sum($time_arr);

            return $time_sum . $md5_str . $ip_sum;
        }
        if($func == 'splitIpTimeSum'){
            $ip_sum = array_sum($ip_arr);
            $time_sum = array_sum($time_arr);

            return $ip_sum . $md5_str . $time_sum;
        }


        //return '';

    }
    public function _real_extract($url)
    {
        $member = $this->_member;

        $url = $this->_tests[$member]['url'];

        //$webpage = $this->_cget($url);  // url source
        $playlist_result = [];          // _extract_playlist

        $tvid = $this->_tests[$member]['tvid'];
        $video_id = $this->_tests[$member]['video_id'];
        $_uuid = $this->uuid();

        $enc_key = $this->get_enc_key();
        $raw_data = $this->get_raw_data($tvid,$video_id,$enc_key,$_uuid);


        if(!is_array($raw_data) || $raw_data['code'] != 'A000000'){
            // error
            die('Unable to load data at line : '.__LINE__);
        }

        //print_r($raw_data);

        $data = $raw_data['data'];

        $title = $data['vi']['vn'];

        // generate video_urls_dict
        $video_urls_dict = $this->construct_video_urls($data, $video_id, $_uuid, $tvid);




    }

    public function _authenticate_vip_video($api_video_url, $video_id, $tvid, $_uuid, $do_report_warning)
    {
        $auth_params = [
        // version and platform hard-coded in com/qiyi/player/core/model/remote/AuthenticationRemote.as
        'version'=>'2.0',
            'platform'=>'b6c13e26323c537d',
            'aid'=>$tvid,
            'tvid'=>$tvid,
            'uid'=>'',
            'deviceId'=>$_uuid,
            'playType'=>'main',  // XXX: always main?
            'filename'=>''  // os.path.splitext(url_basename(api_video_url))[0],
            // print_r(parse_url($api_video_url));
        ];





    }
    public function construct_video_urls($data, $video_id, $_uuid, $tvid)
    {
        $video_urls_dict = [];
        $need_vip_warning_report = True;
        /*
        foreach($data['vp']['tk'][0]['vs'] as $format_item){

            print_r($format_item);
        }
        */
        return '';

    }



    public function get_raw_data($tvid,$video_id,$enc_key,$_uuid)
    {
        $tm = time();
        $tail = $tm . $tvid;
        $param = [
            'key'=> 'fvip',
            'src'=> md5('youtube-dl'),
            'tvId'=> $tvid,
            'vid'=> $video_id,
            'vinfo'=> 1,
            'tm'=> $tm,
            'enc'=> md5($enc_key . $tail),
            'qyid'=> $_uuid,
            'tn'=> mt_rand(),
            'um'=> 1,
            'authkey'=> md5(md5('') . $tail),
            'k_tag'=> 1,
        ];

        $query = http_build_query($param);
        $api_url = 'http://cache.video.qiyi.com/vms' . '?' . $query;

        //echo $api_url;

        $raw_data = json_decode($this->_cget($api_url),true);

        return $raw_data;
    }

    public function get_enc_key()
    {
        //$enc_key = '4a1caba4b4465345366f28da7c117d20';
        return self::ENC_KEY;
    }

    public function uuid()
    {
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

    public function http_status($url)
    {
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

    public function http_cookies($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);
        list($header, $body) = explode("\r\n\r\n", $content);
        preg_match("/set\-cookie:([^\r\n]*)/i", $header, $matches);
        $cookie = $matches[1];
        return $cookie;
    }

    function get_url_content($url,$cookie='',$data='',$ref=''){
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

    public function _cget($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function dd($data,$msg='')
    {
        if($msg!=''){
            echo "----------------\n<br/>";
            echo $msg,' : ';
        }

        if(is_array($data)){
            echo '<pre>';
            print_r($data);
        }else{
            echo "\n<br/>";
            echo $data;
            echo "\n<br/>";
        }
    }

}


$obj = new IqiyiIE($email,$passwd);
//$obj -> _real_initialize();
$obj -> _login();
//$obj -> _real_extract('real url defined in _tests');



class JavaScriptUnpacker
{
    protected $alphabet = array(
        52 => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP',
        54 => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQR',
        62 => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        95 => ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~'
    );
    private $base;
    private $map;
    public function unpack($source, $dynamicHeader = true)
    {
        if (! $this->isPacked($source, $dynamicHeader)) {
            return $source;
        }
        preg_match("/}\('(.*)',\s*(\d+),\s*(\d+),\s*'(.*?)'\.split\('\|'\)/", $source, $match);
        $payload = $match[1];
        $this->base = (int) $match[2];
        $count = (int) $match[3];
        $this->map = explode('|', $match[4]);
        if ($count != count($this->map)) {
            return $source;
        }
        $result = preg_replace_callback('#\b\w+\b#', array($this, 'lookup'), $payload);
        $result = strtr($result, array('\\' => ''));
        return $result;
    }
    public function isPacked($source, $dynamicHeader = true)
    {
        $header = $dynamicHeader ? '\w+,\w+,\w+,\w+,\w+,\w+' : 'p,a,c,k,e,[rd]';
        $source = strtr($source, array(' ' => ''));
        return (bool) preg_match('#^eval\(function\('.$header.'\){#i', trim($source));
    }
    protected function lookup($match)
    {
        $word = $match[0];
        $unbased = $this->map[$this->unbase($word, $this->base)];
        return $unbased ? $unbased : $word;
    }
    protected function unbase($value, $base)
    {
        if (2 <= $base && $base <= 36) {
            return intval($value, $base);
        }
        static $dict = array();
        $selector = $this->getSelector($base);
        if (empty($dict[$selector])) {
            $dict[$selector] = array_flip(str_split($this->alphabet[$selector]));
        }
        $result = 0;
        $array = array_reverse(str_split($value));
        for ($i = 0, $count = count($array); $i < $count; $i++) {
            $cipher = $array[$i];
            $result += pow($base, $i) * $dict[$selector][$cipher];
        }
        return $result;
    }
    protected function getSelector($base)
    {
        if ($base > 62) {
            return 95;
        }
        if ($base > 54) {
            return 62;
        }
        if ($base > 52) {
            return 54;
        }
        return 52;
    }
}