<?php

namespace Swissup\Easyflags\Block\Fieldset;

use Magento\Framework\View\Element\Template;

class HtmlContent extends Template
{
    /**
     * {@inheritdoc}
     */
    protected $_template = 'fieldset/html-content.phtml';

    /**
     * @var \Swissup\Core\Api\Media\FileInfoInterface
     */
    protected $fileInfo;

    /**
     * @var \Swissup\Easyflags\Model\StoreFactory
     */
    protected $storeFlagFactory;

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Swissup\Core\Api\Media\FileInfoInterface $fileInfo,
        \Swissup\Easyflags\Model\StoreFactory $storeFlagFactory,
        Template\Context $context,
        array $data = []
    ) {
        $this->fileInfo = $fileInfo;
        $this->storeFlagFactory = $storeFlagFactory;
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getJsLayout()
    {
        // add current value of store image to jsLayout
        $storeId = $this->getRequest()->getParam('store_id', null);
        $storeFlag = $this->storeFlagFactory->create()->load($storeId);
        if ($storeFlag->getImage()) {
            $path = implode(
                '/',
                [
                    'components', 'swissup_easyflags_fieldset',
                    'children', 'easyflags_image'
                ]
            );
            $imageComponent = &$this->getJsLayoutDataRefenrece($path);
            $imageComponent['value'] = [
                $this->fileInfo->getImageData($storeFlag->getImage())
            ];
        }

        return parent::getJsLayout();
    }

    /**
     * Get reference to data in jsLayout
     *
     * @param  string $path
     * @return mixed
     */
    private function &getJsLayoutDataRefenrece($path)
    {
        $keys = explode('/', $path);

        $data = &$this->jsLayout;
        foreach ($keys as $key) {
            if ((array)$data === $data && isset($data[$key])) {
                $data = &$data[$key];
            } else {
                return null;
            }
        }

        return $data;
    }

}
