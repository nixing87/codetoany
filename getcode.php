<?php
/**
 * @author: Liang
 * @link: https://github.com/nixing87/codetoany
 * @blog: http://liang.zone
 */

require 'library/Authorize.php';

$appId = 'wx506a80282805f83c';
$authorize = new Liang\Weixin\Authorize($appId);
$redirectUrlConfig = [
	'demo1' => 'http://liang.zone.com/?abc=123',
    'demo2' => 'http://liang.zone.com',
	'demo3' => 'https://www.baidu.com/s?wd=codetoany&ie=utf-8',
];
$authorize->authorizeCodeToUrl($redirectUrlConfig);
