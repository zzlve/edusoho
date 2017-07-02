<?php

namespace AppBundle\Component\WeblibAuth;

use Codeages\Weblib\Auth\KeyProvider;
use Codeages\Weblib\Auth\AccessKey;
use Topxia\Service\Common\ServiceKernel;

class AuthKeyProvider implements KeyProvider
{
    public function get($id)
    {
        $storage = $this->getSettingService()->get('storage', array());
        $accessKey = $storage['cloud_access_key'];
        $secretKey = $storage['cloud_secret_key'];

        return new AccessKey($accessKey, $secretKey, 'active', time() + 3600);
    }

    protected function getSettingService()
    {
        return ServiceKernel::instance()->createService('System:SettingService');
    }
}
