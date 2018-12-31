<?php
namespace Swissup\Easyflags\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;

class Data extends AbstractHelper
{
    /**
     * @var \Swissup\Easyflags\Model\StoreFactory
     */
    protected $storeFlagFactory;

    /**
     * @var \Swissup\Core\Api\Media\FileInfoInterface
     */
    protected $fileInfo;

    public function __construct(
        \Swissup\Easyflags\Model\StoreFactory $storeFlagFactory,
        \Swissup\Core\Api\Media\FileInfoInterface $fileInfo,
        Context $context
    ) {
        $this->storeFlagFactory = $storeFlagFactory;
        $this->fileInfo = $fileInfo;
        parent::__construct($context);
    }

    public function isEnabled()
    {
        return (bool)$this->scopeConfig->getValue('easyflags/general/enabled');
    }

    public function getImageUrl($storeId)
    {
        $storeFlag = $this->storeFlagFactory->create();
        $storeFlag->load($storeId);
        if ($storeFlag->getId()) {
            return $this->fileInfo->getBaseUrl() . '/' . $storeFlag->getImage();
        }

        return '';
    }
}