<?php
namespace Swissup\Easyflags\Block;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\ScopeInterface;

class Flags extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * @var \Magento\Store\Model\ResourceModel\Store\CollectionFactory
     */
    protected $storeCollectionFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Store\Collection
     */
    protected $storeCollection;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    /**
     * url builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        // \Magento\Store\Model\ResourceModel\Store\CollectionFactory $storeCollectionFactory,
        \Magento\Store\Model\StoreManager $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        // \Swissup\Easyflags\Helper\Config $configHelper,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        // $this->storeCollectionFactory = $storeCollectionFactory;
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Returns array of storeIDs
     *
     * @return array
     */
    public function getStores()
    {
        return $this->storeManager->getGroup()->getStores();
        // if (null === $this->storeCollection) {
        //     $this->storeCollection = $this->storeCollectionFactory->create();
        //     $this->storeCollection->addGroupFilter();
        // }
        // return $this->storeCollection;
    }

    /**
     * get images base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->urlBuilder->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]).'easyflags/stores';
    }

    /**
     * get media folder url + easyflags
     *
     * @return string
    */
    function getMediaBaseUrl() {
        /** @var \Magento\Framework\ObjectManagerInterface $om */
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = $om->get('Magento\Store\Model\StoreManagerInterface');
        /** @var \Magento\Store\Api\Data\StoreInterface|\Magento\Store\Model\Store $currentStore */
        $currentStore = $storeManager->getStore();
        return $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA). "easyflags/";
    }

    public function getConfig()
    {
        $config = [];
        foreach ($this->getStores() as $store) {
            $image = $this->scopeConfig->getValue(
                'easyflags/general/image',
                ScopeInterface::SCOPE_STORE,
                $store->getCode()
            );
            $config[$store->getCode()] =  $image;
                // 'name' => $store->getName(),
                // 'href' => $store->getCurrentUrl(),
                // 'store_url' => $store->getUrl()
                // 'data-post' => copy from default labguage swither block
                //
                //$store->getUrl()
            // ;
        }
        // Zend_Debug::dump($config, null, true);
        return $config;
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return ['EasyflagsBlock'];
    }
}