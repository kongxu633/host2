<?php
/**
 * Created by PhpStorm.
 * User: tom
 * Date: 16/6/12
 * Time: 上午10:59
 */


// public key extracted from http://static.iqiyi.com/js/qiyiV2/20160129180840/jobs/i18n/i18nIndex.js
// N = 0xab86b6371b5318aaa1d3c9e612a9f1264f372323c8c0f19875b5fc3b3fd3afcc1e5bec527aa94bfa85bffc157e4245aebda05389a5357b75115ac94f074aefcd;
// e = 0x10001

// change N,e 16 to 10
// change function
// $N = dec_from('ab86b6371b5318aaa1d3c9e612a9f1264f372323c8c0f19875b5fc3b3fd3afcc1e5bec527aa94bfa85bffc157e4245aebda05389a5357b75115ac94f074aefcd');

$N = '8983556970082806072261113298370959076142893170423488416059191100210358114802049032983889493302173157165863643606239492524847800665553743035328512591065037';
$e = '65537';

echo '从JS中获取的 e,N 从16进制转换成10进制:';
echo '<br>';
echo dec_from('ab86b6371b5318aaa1d3c9e612a9f1264f372323c8c0f19875b5fc3b3fd3afcc1e5bec527aa94bfa85bffc157e4245aebda05389a5357b75115ac94f074aefcd');
echo '<br>';
echo dec_from('10001');
echo '<br>';
echo '--------------<br>';


$mima = 'admin123';
$arr = str_split($mima);
$hex_str = '';
for($i=count($arr)-1;$i>=0;$i--){
    $hex_str .= dechex(ord($arr[$i]));
}

echo '计算倒叙结果:';
echo '<br>';
echo $hex_str;
echo '<br>';
echo '--------------<br>';

$dec_str = dec_from($hex_str);

$tmp = bcpowmod($dec_str,$e,$N);

$result = dec_to($tmp);

echo '得到最终结果:';
echo '<br>';
echo $result;
echo '<br>';
echo '--------------<br>';


/*
 * 提供 python 原型测试代码
 * */
/*
# coding: utf-8

import binascii


def _rsa_fun(data):
    # public key extracted from http://static.iqiyi.com/js/qiyiV2/20160129180840/jobs/i18n/i18nIndex.js

    N = 0xab86b6371b5318aaa1d3c9e612a9f1264f372323c8c0f19875b5fc3b3fd3afcc1e5bec527aa94bfa85bffc157e4245aebda05389a5357b75115ac94f074aefcd
    #N = 8983556970082806460468248884406486868082820664666888620082026682284424006482262202686484640822640066008860260402866802806408480288228848224246684068624666

    e = 65537

    return ohdave_rsa_encrypt(data, e, N)

def ohdave_rsa_encrypt(data,exponent,modulus):
    # data 反转 转换成16进制 算成10进制结果
    payload = int(binascii.hexlify(data[::-1]), 16)

    encrypted = pow(payload, exponent, modulus)

    print data[::-1] #321nimda
    print binascii.hexlify(data[::-1]) #3332316e696d6461
    print payload #3689065395054797921
    print encrypted #8288895905949347909824503429378404162535006735792979801458034294649444842047674800749355099698561366085255928534390597267337147833191845367623758721560854

    return '%x' % encrypted


print _rsa_fun('admin123') #9e43477b5d89527ca7dcedfdde7720a7745d3486f69dba122e4d0df0d06a4df0462a4205a052e83dab286e2d4e33ebdb86a9344c4353fd792a8fadcb550bb116

print 'this is result:'
print pow(3689065395054797921,65537,8983556970082806072261113298370959076142893170423488416059191100210358114802049032983889493302173157165863643606239492524847800665553743035328512591065037)
*/



$result = str_baseconvert('ab86b6371b5318aaa1d3c9e612a9f1264f372323c8c0f19875b5fc3b3fd3afcc1e5bec527aa94bfa85bffc157e4245aebda05389a5357b75115ac94f074aefcd',16,10);

echo '16进制数转10进制,得到最终结果:';
echo '<br>';
echo $result;
echo '<br>';
echo '--------------<br>';


/**
 * http://php.net/manual/zh/function.base-convert.php#109660
 * 任意进制间的相互转换
 *
 * @param $str
 * @param int $frombase
 * @param int $tobase
 * @return int|string
 */
function str_baseconvert($str, $frombase=10, $tobase=36) {
    $str = trim($str);
    if (intval($frombase) != 10) {
        $len = strlen($str);
        $q = 0;
        for ($i=0; $i<$len; $i++) {
            $r = base_convert($str[$i], $frombase, 10);
            $q = bcadd(bcmul($q, $frombase), $r);
        }
    }
    else $q = $str;

    if (intval($tobase) != 10) {
        $s = '';
        while (bccomp($q, '0', 0) > 0) {
            $r = intval(bcmod($q, $tobase));
            $s = base_convert($r, 10, $tobase) . $s;
            $q = bcdiv($q, $tobase, 0);
        }
    }
    else $s = $q;

    return $s;
}

/**
 * 十进制数转换成其它进制
 * 可以转换成2-62任何进制
 *
 * @param integer $num
 * @param integer $to
 * @return string
 */
function dec_to($num, $to = 16) {
    if ($to == 10 || $to > 62 || $to < 2) {
        return $num;
    }
    $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $ret = '';
    do {
        $ret = $dict[bcmod($num, $to)] . $ret;
        $num = bcdiv($num, $to);
    } while ($num > 0);
    return $ret;
}

/**
 * 其它进制数转换成十进制数
 * 适用2-62的任何进制
 *
 * @param string $num
 * @param integer $from
 * @return number
 */
function dec_from($num, $from = 16) {
    if ($from == 10 || $from > 62 || $from < 2) {
        return $num;
    }
    $num = strval($num);
    $dict = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($num);
    $dec = 0;
    for($i = 0; $i < $len; $i++) {
        $pos = strpos($dict, $num[$i]);
        if ($pos >= $from) {
            continue; // 如果出现非法字符，会忽略掉。比如16进制中出现w、x、y、z等
        }
        $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
    }
    return $dec;
}
