<?php
namespace Swissup\Easyflags\Helper;

use Swissup\Easyflags\Model\ResourceModel\Store as ResourceFlag;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\DataObject;

class Data extends AbstractHelper
{
    /**
     * @var array
     */
    private $flags;

    /**
     * @var ResourceFlag
     */
    protected $resourceFlag;

    /**
     * @var \Swissup\Core\Api\Media\FileInfoInterface
     */
    protected $fileInfo;

    /**
     * @param ResourceFlag                              $resourceFlag
     * @param \Swissup\Core\Api\Media\FileInfoInterface $fileInfo
     * @param Context                                   $context
     */
    public function __construct(
        ResourceFlag $resourceFlag,
        \Swissup\Core\Api\Media\FileInfoInterface $fileInfo,
        Context $context
    ) {
        $this->resourceFlag = $resourceFlag;
        $this->fileInfo = $fileInfo;
        parent::__construct($context);
    }

    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'easyflags/general/enabled',
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getImageUrl($storeId)
    {
        $storeFlag = $this->readData($storeId);

        return $storeFlag->getImage()
            ? $this->fileInfo->getBaseUrl() . '/' . $storeFlag->getImage()
            : '';
    }

    public function getLanguageSwitcherMode()
    {
        return $this->scopeConfig->getValue(
            'easyflags/lang_switcher/mode',
            ScopeInterface::SCOPE_STORE
        );
    }

    private function readData($storeId)
    {
        if (!isset($this->flags)) {
            $this->flags = $this->resourceFlag->readData();
        }

        $data = ['id' => $storeId] + ($this->flags[$storeId] ?? []);

        return new DataObject($data);
    }
}
