<?php

namespace I95Dev\CustomPrice\Controller\Index;

Abstract class Index extends \Magento\Backend\App\Action
{
    protected $scopeConfig;
    protected $storeManager;
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }
    public function getConfigValue() {
       $value = $this->scopeConfig->getValue("pricepart/general/enable",
           \Magento\Store\Model\ScopeInterface::SCOPE_STORE,$this->storeManager->getStore()->getStoreId());
       return $value;
    }

}
