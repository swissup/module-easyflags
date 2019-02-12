<?php

namespace Swissup\Easyflags\Helper\Ui;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\ProductMetadataInterface;

/**
 * Until ver 2.3.0 Magento did not have separate image uploader component.
 * So general file uploader component was used.
 */
class ImageUploader extends AbstractHelper
{
    /**
     * @var ProductMetadataInterface
     */
    protected $magentoMetadata;

    /**
     * Constructor
     *
     * @param Context                  $context
     * @param ProductMetadataInterface $productMetadata
     */
    public function __construct(
        Context $context,
        ProductMetadataInterface $productMetadata
    ) {
        $this->magentoMetadata = $productMetadata;
        parent::__construct($context);
    }

    /**
     * Get path to image uploader UI component depending on Magento version.
     *
     * @return string
     */
    public function getComponent()
    {
        $component = 'Magento_Ui/js/form/element/image-uploader';
        if (version_compare($this->magentoMetadata->getVersion(), '2.3.0', '<')) {
            $component = 'Magento_Ui/js/form/element/file-uploader';
        }

        return $component;
    }

    /**
     * Get path to image uploader UI component depending on Magento version.
     *
     * @return string
     */
    public function getFormElement()
    {
        $formElement = 'imageUploader';
        if (version_compare($this->magentoMetadata->getVersion(), '2.3.0', '<')) {
            $formElement = 'fileUploader';
        }

        return $formElement;
    }
}
