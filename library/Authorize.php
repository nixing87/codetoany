<?php
/**
 * @author: Liang
 * @link: https://github.com/nixing87/codetoany
 * @blog: http://liang.zone
 */

namespace Liang\Weixin;

class Authorize
{
	private $_isFromWeixinGetParamName = '__is_from_weixin_liang__';
	private $_isFromWeixinGetParamValue = 'yes';

	public $appId;
	public $isHttps = false;

	public function __construct($appId)
	{
		$this->appId = $appId;
	}

	public function authorizeCodeToUrl(array $authorizeUrlConfig = [], $authorizeUrlGetParamName = 'auk', $isOverrideAuthorizeUrlGetParam = false)
	{
		$finalAuthorizeUrl = '';
		if (!empty($_GET[$this->_isFromWeixinGetParamName]) && $_GET[$this->_isFromWeixinGetParamName] == $this->_isFromWeixinGetParamValue) {
			if (!empty($_GET[$authorizeUrlGetParamName])) {
				$authorizeUrlKey = $_GET[$authorizeUrlGetParamName];
				if (!empty($authorizeUrlConfig[$authorizeUrlKey])) {
					$finalAuthorizeUrl = $authorizeUrlConfig[$authorizeUrlKey];
					$filterGetParamName = [$this->_isFromWeixinGetParamName, $authorizeUrlGetParamName];
					$forceGetParamName = ['code', 'state'];
					$newGetParam = [];
					foreach ($_GET as $k => $v) {
						if (in_array($k, $forceGetParamName) || (!in_array($k, $filterGetParamName) && ($isOverrideAuthorizeUrlGetParam || !preg_match("/[\?|\&]{$k}\=/", $finalAuthorizeUrl)))) {
							$newGetParam[$k] = $v;
						}
					}
					if ($newGetParam) {
						$finalAuthorizeUrl .= (strpos($finalAuthorizeUrl, '?') === false ? '?' : '&') . http_build_query($newGetParam);
					}
				}
			}
		} else {
			$apiGetParamState = empty($_GET['state']) ? 'STATE' : $_GET['state'];
			unset($_GET['state']);
			$_GET[$this->_isFromWeixinGetParamName] = $this->_isFromWeixinGetParamValue;
			$apiGetParamRedirectUrl = explode('?', $_SERVER['REQUEST_URI']);
			$apiGetParamRedirectUrl = 'http' . ($this->isHttps ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $apiGetParamRedirectUrl[0] . '?' . urldecode(http_build_query($_GET));
			$apiGetParam['appid'] = $this->appId;
			$apiGetParam['redirect_uri'] = urlencode($apiGetParamRedirectUrl);
			$apiGetParam['response_type'] = 'code';
			$apiGetParam['scope'] = empty($_GET['scope']) || !in_array($_GET['scope'], ['snsapi_base', 'snsapi_userinfo']) ? 'snsapi_base' : $_GET['scope'];
			$apiGetParam['state'] = "{$apiGetParamState}#wechat_redirect";
			$finalAuthorizeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?' . urldecode(http_build_query($apiGetParam));
		}
		if ($finalAuthorizeUrl) {
			header("Location: {$finalAuthorizeUrl}");
		}
	}
}
