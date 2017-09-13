# PhalApi_Web
PhalApi是一个PHP轻量级开源接口框架，致力于快速开发接口服务，
集成
* 拦截器，
* token校验验证,
* 接口签名校验、
* PhpQuery爬虫集成

```php
class PhalApi_Filter_SimpleMD5 implements PhalApi_Filter {

    protected $signName;

    public function __construct($signName = 'sign') {
        $this->signName = $signName;
    }

    /**
     * 签名验证 去除了sign和方法名参数
     * @throws PhalApi_Exception_BadRequest
     */
    public function check() {

        $service = DI()->request->get('service');
        $app=DI()->config->get('app');
        $apiFilterRules = $app['apiFilterRules'];
        if (!in_array($service,$apiFilterRules)) {
            $allParams = DI()->request->getAll();

            $sign = isset($allParams[$this->signName]) ? $allParams[$this->signName] : '';
            unset($allParams[$this->signName]);
            unset($allParams['service']);

            //加上appkey
            $sys = DI()->config->get('sys');
            $allParams['appkey'] = $sys['appkey'];
            $expectSign = $this->encryptAppKey($allParams);

            if ($expectSign != $sign) {
                DI()->logger->debug('Wrong Sign', array('needSign' => $expectSign));
                throw new PhalApi_Exception_BadRequest(T('wrong sign'), 6);
            }
        }
    }

    protected function encryptAppKey($params) {
        ksort($params);

        $paramsStrExceptSign = '';
        foreach ($params as $val) {
            $paramsStrExceptSign .= $val;
        }

        return MD5($paramsStrExceptSign);

    }
}

```
