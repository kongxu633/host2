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
