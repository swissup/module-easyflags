<?php

namespace Swissup\Easyflags\Plugin\Backend\Block\Grid\Render;

class Store
{
    /**
     * @var \Magento\Framework\View\Element\Template
     */
    private $flagRenderer;

    /**
     * @var \Magento\Framework\DataObject
     */
    private $currentRow;

    /**
     * @param \Magento\Framework\View\Element\TemplateFactory $blockFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\TemplateFactory $blockFactory
    ) {
        $this->flagRenderer = $blockFactory->create();
        $this->flagRenderer->setTemplate('Swissup_Easyflags::renderer/flag.phtml');
    }

    /**
     * Before plugin to catch grid row
     * (compatibility with Magento 2.1)
     *
     * @param  \Magento\Backend\Block\System\Store\Grid\Render\Store $subject
     * @param  \Magento\Framework\DataObject                         $row
     */
    public function beforeRender(
        \Magento\Backend\Block\System\Store\Grid\Render\Store $subject,
        \Magento\Framework\DataObject $row
    ) {
        $this->currentRow = $row;
    }

    /**
     * After plugin to add flag image
     *
     * @param  \Magento\Backend\Block\System\Store\Grid\Render\Store $subject
     * @param  string                                                $html
     * @return string
     */
    public function afterRender(
        \Magento\Backend\Block\System\Store\Grid\Render\Store $subject,
        $html
    ) {
        if (!$this->currentRow) {
            return $html;
        }

        $this->flagRenderer->setStoreId($this->currentRow->getStoreId());
        return $this->flagRenderer->toHtml() . $html;
    }
}
