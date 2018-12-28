<?php

namespace Swissup\Easyflags\Observer;

use Magento\Framework\Event;
use Magento\Framework\View\Element\Template;
use Swissup\Easyflags\Block\Widget\Form\Renderer\Fieldset as FieldsetRenderer;

class AddFlagData implements Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Framework\Registry $registry
    ) {
        $this->registry = $registry;
    }

    /**
     * @param  Event\Observer $observer
     * @return void
     */
    public function execute(Event\Observer $observer)
    {
        if ($this->registry->registry('store_type') == 'store') {
            $block = $observer->getData('block');
            $htmlConetnt = $block->getLayout()
                ->getBlock('swissupEasyflagsFieldset');
            if (!$htmlConetnt) {
                return;
            }

            $form = $block->getForm();
            // change form encryption to be able sumbit media content
            $form->setEnctype('multipart/form-data');
            $fieldset = $form->addFieldset(
                'easyflags_fieldset',
                [
                    'legend' => __('Easy Flags'),
                    'html_content' => $htmlConetnt->toHtml()
                ]
            );
        }
    }
}
