<?php

namespace Swissup\Easyflags\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $this->createStoreTable($setup);
        }

        $setup->endSetup();
    }

    /**
     * @param  SchemaSetupInterface $setup
     */
    protected function createStoreTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable('swissup_easyflags_store'))
            ->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                [
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ],
                'Store Id'
            )->addColumn(
                'image',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => true,
                    'default' => null
                ],
                'Image'
            )->addForeignKey(
                $setup->getFkName(
                    'swissup_easyflags_store',
                    'store_id',
                    'store',
                    'store_id'
                ),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Easyflags data for store view'
            );
        $setup->getConnection()->createTable($table);
    }
}
