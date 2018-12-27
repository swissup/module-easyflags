<?php

namespace Swissup\Easyflags\Observer;

use Magento\Framework\Event;
use Magento\Framework\View\Element\Template;
use Swissup\Easyflags\Block\Widget\Form\Renderer\Fieldset as FieldsetRenderer;

class AddFlagFieldset implements Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Registry $registry
     * @param FieldsetRenderer            $fieldsetRenderer
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        FieldsetRenderer $fieldsetRenderer
    ) {
        $this->registry = $registry;
        $this->fieldsetRenderer = $fieldsetRenderer;
    }

    /**
     * @param  Event\Observer $observer
     * @return void
     */
    public function execute(Event\Observer $observer)
    {
        if ($this->registry->registry('store_type') == 'store') {
            $block = $observer->getData('block');
            $uploaderBlock = $block->getLayout()
                ->getBlock('swissupEasyflagsUplaoder');
            if (!$uploaderBlock) {
                return;
            }

            $form = $block->getForm();
            // change form encryption to be able sumbit media content
            $form->setEnctype('multipart/form-data');
            $fieldset = $form->addFieldset(
                'easyflags_fieldset',
                [
                    'legend' => __('Easy Flags'),
                    'data-bind' => 'scope: "swissup_easyflags_uploader"',
                    'data-mage-init' => $this->prepareMageInit($uploaderBlock),
                    'html_content' => $this->prepareHtmlContent($uploaderBlock)
                ]
            )->setRenderer($this->fieldsetRenderer);
        }
    }

    /**
     * Return value for data-mage-init attribute
     *
     * @param  Template $block
     * @return string
     */
    private function prepareMageInit(Template $block)
    {
        return '{"Magento_Ui/js/core/app" : ' . $block->getJsLayout() . '}';
    }

    /**
     * Returns KO template to render UI Component
     *
     * @param  Template $block
     * @return string
     */
    private function prepareHtmlContent(Template $block)
    {
        return $block->toHtml();
    }
}
