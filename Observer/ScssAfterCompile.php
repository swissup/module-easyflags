<?php

namespace Swissup\Easyflags\Observer;

class ScssAfterCompile implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Swissup\Easyflags\Helper\Data
     */
    private $helper;

    /**
     * @param \Swissup\Easyflags\Helper\Data $helper
     */
    public function __construct(
        \Swissup\Easyflags\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param  \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->helper->isEnabled()) {
            return;
        }

        $transport = $observer->getTransport();
        $styles = $transport->getStyles()
            . '.easyflags amp-accordion .current,.easyflags amp-accordion a{display:flex!important;align-items:center}'
            . '.easyflags img{object-fit:contain;max-width:32px}'
            . '.easyflags .flag-title{margin:0 5px}'
            . '.switcher-language amp-accordion section .current{padding:7px}'
            . '.switcher-language amp-accordion section .current::before{content:unset}';
        $transport->setStyles($styles);
    }
}
