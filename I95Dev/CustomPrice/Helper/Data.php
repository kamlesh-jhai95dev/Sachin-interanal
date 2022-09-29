<?php

namespace I95Dev\CustomPrice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    protected $scopeConfig;

const XML_PATH_KEY = 'pricepart/general/enable';// add your path here

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }

    public function getFieldVal($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_KEY, $storeId);
    }

}
