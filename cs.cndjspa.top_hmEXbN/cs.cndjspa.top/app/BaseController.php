<?php


declare (strict_types=1);
namespace app;

abstract class BaseController
{
	protected $request;
	protected $app;
	protected $batchValidate = false;
	protected $middleware = [];
	public function __construct(\think\App $app)
	{
		longbing_check_install();
		$this->app = $app;
		$this->request = $this->app->request;
		$this->_method = $this->request->method(true);
		$this->_param = $this->request->param();
		if (in_array($this->_method, ["options", "Options", "OPTIONS"])) {
			echo true;
			exit;
		}
		$this->initialize();
		if ($this->shareChangeData($this->_param) == true) {
			$this->isAuth(666);
		}
	}
	public function shareChangeData($input)
	{
		$arr = ["/admin/admin/config/clear", "/massage/admin/AdminOrder/noLookCount", "/massage/admin/AdminSetting/getSaasAuth", "/agent/admin/isWe7", "/massage/admin/Admin/getConfig", "/massage/admin/Admin/login"];
		if (!empty($input["s"]) && in_array($input["s"], $arr)) {
			return false;
		}
		return true;
	}
	public function isAuth($uniacid)
	{
		include_once LONGBING_EXTEND_PATH . "LongbingUpgrade.php";
		$goods_name = config("app.AdminModelList")["app_model_name"];
		$auth_uniacid = config("app.AdminModelList")["auth_uniacid"];
		$upgrade = new \LongbingUpgrade($auth_uniacid, $goods_name, \think\facade\Env::get("j2hACuPrlohF9BvFsgatvaNFQxCBCc", false));
		$p = $upgrade->isAuthP($uniacid);
		if ($p == 1) {
			return true;
		}
		$this->errorMsg("请联系开发人员授权");
	}
	protected function errorMsg($msg = "", $code = 400)
	{
		$msg = \think\facade\Lang::get($msg);
		$this->results($msg, $code);
	}
	protected function results($msg, $code, array $header = [])
	{
		$result = ["error" => $msg, "code" => $code];
		$response = \think\Response::create($result, "json", 200)->header($header);
		throw new \think\exception\HttpResponseException($response);
	}
	protected function initialize()
	{
	}
	public function success($data, $code = 200)
	{
		$result["data"] = $data;
		$result["code"] = $code;
		$result["sign"] = null;
		if (!empty($this->_token)) {
			$result["sign"] = createSimpleSign($this->_token, is_string($data) ? $data : json_encode($data));
		}
		return $this->response($result, "json", $code);
	}
	public function error($msg, $code = 400)
	{
		$result["error"] = \think\facade\Lang::get($msg);
		$result["code"] = $code;
		return $this->response($result, "json", 200);
	}
	protected function response($data, $type = "json", $code = 200)
	{
		return \think\Response::create($data, $type)->code($code);
	}
	protected function validate(array $data, $validate, array $message = [], bool $batch = false)
	{
		if (is_array($validate)) {
			$v = new \think\Validate();
			$v->rule($validate);
		} else {
			if (strpos($validate, ".")) {
				list($validate, $scene) = explode(".", $validate);
			}
			$class = false !== strpos($validate, "\\") ? $validate : $this->app->parseClass("validate", $validate);
			$v = new $class();
			if (!empty($scene)) {
				$v->scene($scene);
			}
		}
		$v->message($message);
		if ($batch || $this->batchValidate) {
			$v->batch(true);
		}
		return $v->failException(true)->check($data);
	}
}