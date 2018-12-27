<?php

namespace Swissup\Easyflags\Model;

class Store extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Swissup\Easyflags\Model\ResourceModel\Store::class);
    }
}
