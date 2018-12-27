<?php

namespace Swissup\Easyflags\Block\Widget\Form\Renderer;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Fieldset extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset
{
    /**
     * {@inheritdoc}
     */
    public function render(AbstractElement $element)
    {
        $html = parent::render($element);
        $dataAttributes = ['data-bind', 'data-mage-init'];
        $attributesHtml = $element->serialize($dataAttributes, '=', ' ', "'");
        // insert data attributes for KO in fieldset element
        $html = str_replace(
            "id=\"{$element->getHtmlId()}\"",
            "id=\"{$element->getHtmlId()}\" {$attributesHtml}",
            $html
        );
        return $html;
    }
}
