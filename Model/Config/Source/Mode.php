<?php

namespace Swissup\Easyflags\Model\Config\Source;

class Mode implements \Magento\Framework\Option\ArrayInterface
{

    const ONELINE = 'one-line';
    const DROPDOWN = 'dropdown';
    const POPUP = 'popup';


    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::ONELINE,
                'label' => __('One line')
            ],
            [
                'value' => self::DROPDOWN,
                'label' => __('Dropdown')
            ],
            [
                'value' => self::POPUP,
                'label' => __('Modal popup')
            ]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $option) {
            $array[$option['value']] = $optin['label'];
        }

        return $array;
    }
}
