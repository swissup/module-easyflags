<?php

namespace Swissup\Easyflags\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Store extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected $_isPkAutoIncrement = false;

    /**
     * Model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('swissup_easyflags_store', 'store_id');
    }

    /**
     * @param  array  $storeIds
     * @return array
     */
    public function readData(array $storeIds = [])
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($this->getMainTable());
        if (!empty($storeIds)) {
            $select->where('store_id IN (?)', $storeIds);
        }

        return $connection->fetchAssoc($select);
    }
}
