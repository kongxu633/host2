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

    public static function _login()
    {
        echo 'haha';
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
        echo $data;
        echo "\n<br/>";
        if(is_array($data)){
            echo '<pre>';
            print_r($data);
        }
    }

}


$obj = new IqiyiIE();
$obj -> _real_initialize();
$obj -> _real_extract('real url defined in _tests');



