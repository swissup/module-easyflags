<?php

namespace Swissup\Easyflags\Observer;

use Magento\Framework\Event;

class SaveFlagData implements Event\ObserverInterface
{
    public function __construct(
        \Magento\Catalog\Model\ImageUploader $imageUploader
    ) {
        $this->imageUploader = $imageUploader;
    }

    /**
     * Save easyflags data
     *
     * @param  Event\Observer $observer
     * @return void
     */
    public function execute(Event\Observer $observer)
    {
        $request = $observer->getEvent()->getRequest();
        if ($request->isPost()
            && ($postData = $request->getPostValue())
            && !empty($postData['store_type'])
            && !empty($postData['store_action'])
            && $postData['store_type'] === 'store'
        ) {
            $imageField = 'easyflags_image';
            $imageName = '';
            if (isset($postData[$imageField])
                && is_array($postData[$imageField])
            ) {
                $imageName = isset($postData[$imageField][0]['name'])
                    ? $postData[$imageField][0]['name']
                    : '';
                if (isset($postData[$imageField][0]['tmp_name'])) {
                    try {
                        $this->imageUploader->moveFileFromTmp($imageName);
                    } catch (\Exception $e) {
                        //
                    }
                }
            }
        }
    }
}
