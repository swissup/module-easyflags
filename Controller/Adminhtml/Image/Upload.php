<?php

namespace Swissup\Easyflags\Controller\Adminhtml\Image;

use Magento\Backend\Controller\Adminhtml\System\Store;

class Upload extends \Magento\Catalog\Controller\Adminhtml\Category\Image\Upload
{
    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Store::ADMIN_RESOURCE);
    }
}
