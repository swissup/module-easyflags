<?php

namespace Swissup\Easyflags\Observer;

use Magento\Framework\Event;

class SaveFlagData implements Event\ObserverInterface
{
    public function __construct(
        \Magento\Catalog\Model\ImageUploader $imageUploader,
        \Swissup\Easyflags\Model\StoreFactory $storeFlagFactory
    ) {
        $this->imageUploader = $imageUploader;
        $this->storeFlagFactory = $storeFlagFactory;
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

                $storeId = $postData['store']['store_id'];
                $this->storeFlagFactory->create()
                    ->load($storeId)
                    ->setStoreId($storeId)
                    ->setImage($imageName)
                    ->save();
            }
        }
    }
}
