<?php

class LongbingUpgrade
{
	private $uniacid;
	private $goods_name;
	private $base_url;
	private $check_url;
	private $uploadWxapp_url;
	private $get_auth_url;
	private $get_domain_param_url;
	private $http_host;
	private $server_name;
	private $request_time;
	private $public_key;
	private $domain_name_info;
	private $goods_version_info;
	private $goods_version_updata_info;
	private $errorMsg = "授权失败，请联系系统提供商，Tel： 。";
	private $is_debug = false;
	private $token_path;
	public function __construct($uniacid, $goodsName, $is_debug = false)
	{
		$this->is_debug = $is_debug;
		$this->token_path = dirname(__FILE__) . "/token.key";
		$this->uniacid = $uniacid . "";
		$this->goods_name = $goodsName;
		$this->base_url = "https://baidu.com/";
		$this->base_url = $this->is_debug ? "https://baidu.com/" : "http://baidu.com/";
		$this->base_url = "http://baidu.com/";
		$http = $this->curl_post("http://baidu.com/");
		$http = @json_decode($http, true);
		if (!empty($http["url"])) {
			$this->base_url = $http["url"];
		} else {
			$this->base_url = "http://baidu.com/";
		}
		$this->check_url = $this->base_url . "auth/home.Index/index";
		$this->uploadWxapp_url = $this->base_url . "auth/home.Index/uploadWxapp";
		$this->get_auth_url = $this->base_url . "auth/home.Index/getAuth";
		$this->get_domain_param_url = $this->base_url . "auth/home.Index/domain_param";
		$this->get_wxapp_version_url = $this->base_url . "auth/home.Index/getWxappVersion";
		$this->clear_up_token = $this->base_url . "auth/home.Index/clearToken";
		$this->http_host = $_SERVER["HTTP_HOST"];
		$this->server_name = $_SERVER["SERVER_NAME"];
		$this->request_time = $_SERVER["REQUEST_TIME"] . "";
	}
	public function checkAuth()
	{
		try {
			$this->clearUp();
			$this->public_key = $this->getPublicKey();
			$this->getUpgradeMsg();
			if (empty($this->public_key)) {
				return $this->returnErrorDataInfo("(001)" . $this->errorMsg);
			} else {
				$data["domain"] = $this->domain_name_info;
				$data["version"] = $this->goods_version_info;
				return $this->returnDataInfo($data);
			}
		} catch (Exception $e) {
			return $this->returnErrorDataInfo("请用授权域名登陆 进行站点绑定");
		}
	}
	public function isAuthP($uniacid)
	{
		$key = "is_auth_sasss";
		$data = getCache($key, $uniacid);
		if (empty($data)) {
					return 1;
			
		
		}
		return $data;
	}
	private function getAuthMsg()
	{
		if (empty($this->domain_name_info) || count($this->domain_name_info) == 0) {
			return $this->returnDataInfo([], "(002)" . $this->errorMsg);
		} else {
			return $this->returnDataInfo($this->domain_name_info);
		}
	}
	private function getUpgradeMsg()
	{
		try {
			$this->public_key = $this->getPublicKey();
			if (!$this->public_key) {
				return $this->returnErrorDataInfo("请用授权域名登陆 进行站点绑定");
			}
			$siginStr = $this->getSiginData([]);
			$result = $this->curl_post($this->check_url, $this->getPostData($siginStr));
			$result = json_decode($result, true);
			$data = $result["data"];
			openssl_public_decrypt(base64_decode($data["goods_version_updata_info"]), $sigin, $this->public_key);
			$sigin = json_decode($sigin, true);
			$this->goods_version_info = $data["goods_version_info"];
			$this->goods_version_updata_info = $sigin;
			return $this->returnDataInfo($this->goods_version_info);
		} catch (Exception $e) {
			return $this->returnErrorDataInfo("获取更新信息异常");
		}
	}
	public function update($toFilePath = null, $tempPaht = null)
	{
		if (!$this->goods_version_info && !$this->goods_version_updata_info) {
			$this->getUpgradeMsg();
		}
		if ($this->goods_version_updata_info["url"] === "ae40000001") {
			return $this->returnErrorDataInfo("升级服务已到期");
		}
		$result = $this->get_file($this->goods_version_updata_info["url"], $tempPaht);
		if ($result === false) {
			return $this->returnErrorDataInfo("下载文件失败");
		}
		$toFilePath = empty($toFilePath) ? "./" : $toFilePath;
		$this->unzip($result, $toFilePath, $this->goods_version_updata_info["password"]);
		return $this->returnDataInfo([], "更新成功", "200");
	}
	public function returnDataInfo($data = [], $msg = "", $code = 20000)
	{
		$resultData = ["code" => $code, "msg" => $msg, "data" => $data];
		return $resultData;
	}
	public function returnErrorDataInfo($msg = "", $code = -1, $data = [])
	{
		return $this->returnDataInfo($data, $msg, $code);
	}
	public function uploadWxapp($uploadInfo, $wxapp_version = "")
	{
		try {
			$postData = $this->getPostData("");
			$postData["ext_data"] = json_encode($uploadInfo);
			$postData["wxapp_version"] = $wxapp_version;
			$this->log("uploadWxapp = postData", $postData);
			$result = $this->curl_post($this->uploadWxapp_url, $postData);
			$this->log("获取授权信息一", $result);
			$result = json_decode($result, true);
			$this->log("获取授权信息二", $result);
			return empty($result) ? $this->returnErrorDataInfo("上传繁忙，稍后再试。。(001)") : $result;
		} catch (Exception $e) {
			return $this->returnErrorDataInfo("上传繁忙，稍后再试。。(002)");
		}
	}
	public function getWxappVersion($version_no)
	{
		try {
			$postData = $this->getPostData("");
			$postData["version"] = $version_no;
			$this->log("uploadWxapp = postData", $postData);
			$result = $this->curl_post($this->get_wxapp_version_url, $postData);
			$this->log("获取版本信息一", $result);
			$result = json_decode($result, true);
			$this->log("获取版本信息二", $result);
			return $result["data"];
		} catch (Exception $e) {
			return $this->returnErrorDataInfo("无法获取小程序版本信息");
		}
	}
	public function getsAuthConfig()
	{
		$this->public_key = $this->getPublicKey();
		if (empty($this->public_key)) {
			return [];
		}
		$siginStr = $this->getSiginData([]);
		$result = $this->curl_post($this->get_domain_param_url, $this->getPostData($siginStr));
		$result = json_decode($result, true);
		$param_list = $result["data"]["param_list"];
		if (is_array($param_list)) {
			foreach ($param_list as $key => $item) {
				$param = "";
				openssl_public_decrypt(base64_decode($item), $param, $this->public_key);
				$param_list[$key] = $param;
			}
		}
		return $param_list;
	}
	private function getPostData($siginStr)
	{
		$postData = $this->getPublicPostData();
		$postData["sigin"] = $siginStr;
		return $postData;
	}
	private function getSiginData($extData = [], $siginType = 1)
	{
		$data = $this->getPublicPostData();
		if (!empty($extData)) {
			$data["ext_data"] = $extData;
		}
		ksort($data);
		$str_data = json_encode($data);
		if ($siginType == 1) {
			openssl_public_encrypt($str_data, $encrypted, $this->public_key);
			if (empty($encrypted)) {
				return false;
			}
			$encrypted = base64_encode($encrypted);
		} else {
			$encrypted = $this->getSiginDataByHash($data);
		}
		return $encrypted;
	}
	private function getSiginDataByOpenSSL($data)
	{
		$str_data = is_array($data) ? json_encode($data) : $data;
		openssl_public_encrypt($str_data, $encrypted, $this->public_key);
		if (empty($encrypted)) {
			return false;
		}
		$encrypted = base64_encode($encrypted);
		return $encrypted;
	}
	private function getSiginDataByHash($data)
	{
		$data["token"] = $data["token"] ? $data["token"] : "";
		$this->log("getSiginDataByHash data ", $data);
		$data = is_array($data) ? json_encode($data) : (is_string($data) ? $data : time() . "") . "LongbingShuixian";
		$siginStr = hash("sha256", $data);
		return $siginStr;
	}
	private function getPublicPostData()
	{
		$app_model_name = config("app.AdminModelList")["app_model_name"];
		$token = @file_get_contents($this->token_path);
		$token = $token ? json_decode($token, true) : "";
		if (!empty($token)) {
			$token = $token["token"];
		}
		$data = ["uniacid" => $this->uniacid, "app_model_name" => $app_model_name, "goods_name" => $this->goods_name, "http_host" => $this->http_host, "server_name" => $this->server_name, "request_time" => $this->request_time, "token" => $token];
		return $data;
	}
	private function get_file($url, $folder = "./data/upgradex/")
	{
		set_time_limit(86400);
		$target_dir = $folder . "";
		if (!is_dir($target_dir)) {
			mkdir($target_dir, 511, true);
		}
		$newfname = date("Ymd") . rand(1000, 10000000) . uniqid() . ".zip";
		$newfname = $target_dir . $newfname;
		$file = @fopen($url, "rb");
		if ($file) {
			$newf = fopen($newfname, "wb");
			if ($newf) {
				while (!feof($file)) {
					fwrite($newf, fread($file, 8192), 8192);
				}
			}
			fclose($file);
			if ($newf) {
				fclose($newf);
			}
		} else {
			return false;
		}
		return $newfname;
	}
	private function unzip($filename, $toFilepath, $password = null)
	{
		$zip = new ZipArchive();
		$res = $zip->open($filename);
		if ($res === true) {
			$password && $zip->setPassword($password);
			$zip->extractTo($toFilepath);
			$zip->close();
		}
		return true;
	}
	public function log($key, $value)
	{
		if ($this->is_debug) {
			echo $key . " = " . (is_array($value) ? json_encode($value) : $value) . "<br /><br /><br /> ";
		} else {
			return false;
		}
	}
	private function getPublicKey()
	{
		if (!empty($this->public_key)) {
			$this->log("已经获得 ", $this->public_key);
			return $this->public_key;
		}
		$this->log("获取秘钥：", "开始");
		$siginStr = $this->getSiginData([], 2);
		$this->log("获取秘钥 sigin：", $siginStr);
		$result = $this->curl_post($this->get_auth_url, $this->getPostData($siginStr));
		$this->log("获取秘钥 result：", $result);
		$result = json_decode($result, true);
		$this->domain_name_info = $result["data"]["domain_name_info"];
		$this->log("获取秘钥 保持token路径: ", dirname(__FILE__));
		$token = $result["data"]["token"];
		$resultWriteToken = $this->writein_token($token);
		$this->log("获取秘钥 写入token: ", $resultWriteToken ? "成功" : "失败");
		$this->public_key = $result["data"]["public_key"];
		return $this->public_key;
	}
	private function curl_post($url, $data = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	private function writein_token($token) : bool
	{
		$resultWriteToken = false;
		if (is_array($token)) {
			$resultWriteToken = file_put_contents($this->token_path, json_encode($token));
		} else {
			$token = @file_get_contents($this->token_path);
			$token = $token ? json_decode($token, true) : "";
			if (!empty($token)) {
				if ($token["token_expiration_time"] < time()) {
					$token["token"] = "";
					$resultWriteToken = file_put_contents($this->token_path, json_encode($token));
				}
			}
		}
		return $resultWriteToken ? true : false;
	}
	private function clearUp()
	{
		$token = @file_get_contents($this->token_path);
		$token = $token ? json_decode($token, true) : "";
		if (!empty($token)) {
			if ($token["token_expiration_time"] < time() || !$token["token"]) {
				$this->public_key = $this->getPublicKey();
				$siginStr = $this->getSiginData([]);
				$result = $this->curl_post($this->clear_up_token, $this->getPostData($siginStr));
				$result = json_decode($result, true);
				if ($result["data"]["clear"]) {
					$this->public_key = null;
				}
			}
		}
	}
}