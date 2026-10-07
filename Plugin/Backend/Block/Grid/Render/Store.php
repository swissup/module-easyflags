<?php

namespace Swissup\Easyflags\Plugin\Backend\Block\Grid\Render;

class Store
{
    /**
     * @var \Magento\Framework\View\Element\Template
     */
    private $flagRenderer;

    /**
     * @param \Magento\Framework\View\Element\TemplateFactory $blockFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\TemplateFactory $blockFactory
    ) {
        $this->flagRenderer = $blockFactory->create();
        $this->flagRenderer->setTemplate('Swissup_Easyflags::renderer/flag.phtml');
    }

    public function afterRender(
        \Magento\Backend\Block\System\Store\Grid\Render\Store $subject,
        $html,
        \Magento\Framework\DataObject $row
    ) {
        if (!$row) {
            return $html;
        }

        $this->flagRenderer->setStoreId($row->getStoreId());
        return $this->flagRenderer->toHtml() . $html;
    }
}
