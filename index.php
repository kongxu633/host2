<?php

class IqiyiIE{
    const IE_NAME = 'iqiyi';
    const IE_DESC = '爱奇艺';
    //last update at 2016-01-22 for Zombie::bite
    const ENC_KEY = '4a1caba4b4465345366f28da7c117d20';

    const _VALID_URL = '/https?:\/\/(?:(?:[^.]+\.)?iqiyi\.com|www\.pps\.tv)/.+\.html/i';

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

    public function __construct()
    {
        echo self::IE_NAME,'-',self::IE_DESC,'-',$this->now(),'<br/>';
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
        //echo 'haha';
        $token_url = 'http://kylin.iqiyi.com/get_token';
        $token_str = $this->_cget($token_url);
        $token_json = json_decode($token_str,True);

        $data_code = $token_json['code'];
        $data_sdk = $token_json['sdk'];

        $unpacker = new JavascriptUnpacker;

        $unpack_js =$unpacker->unpack($data_sdk);

        $this->dd($unpack_js,'unpacked js to txt');

        $functions = [];
        if(preg_match_all("/input=([a-zA-Z0-9]+)\(input/",$unpack_js,$matches)){
            $functions = $matches[1];
        }

        $this->dd($functions,'check out the functions');

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

    public function _cget($url)
    {
        //初始化
        $ch = curl_init();

        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        //释放curl句柄
        curl_close($ch);

        //打印获得的数据
        //print_r($output);
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


$obj = new IqiyiIE();
$obj -> _real_initialize();
//$obj -> _login();
$obj -> _real_extract('real url defined in _tests');


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