<?php
namespace Swissup\Easyflags\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;

class Config extends AbstractHelper
{
    public function isEnabled()
    {
        return (bool)$this->scopeConfig->getValue('easyflags/general/enabled');
    }

    public function getImage($storeId)
    {
        $image = $this->scopeConfig->getValue(
            'easyflags/general/image',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
        return $this->_urlBuilder->getDirectUrl(
            'easyflags/' . $image,
            ['_type' => UrlInterface::URL_TYPE_MEDIA]
        );
    }
}
