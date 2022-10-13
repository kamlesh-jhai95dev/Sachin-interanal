<?php

namespace I95Dev\CustomShipping\Block\Backend\System;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context as TemplateContext;
use Magento\Store\Model\Website;
use Magento\Ups\Helper\Config as ConfigHelper;


class CarrierConfig extends Template
{

    protected $carrierConfig;

    /**
     * @var \Magento\Store\Model\Website
     */
    protected $_websiteModel;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Ups\Helper\Config $carrierConfig
     * @param \Magento\Store\Model\Website $websiteModel
     * @param array $data
     */
    public function __construct(
        TemplateContext $context,
        ConfigHelper $carrierConfig,
        Website $websiteModel,
        array $data = []
    ) {
        $this->carrierConfig = $carrierConfig;
        $this->_websiteModel = $websiteModel;
        parent::__construct($context, $data);
    }


    public function getCarrierConfig()
    {
        return $this->carrierConfig;
    }

    public function getWebsiteModel()
    {
        return $this->_websiteModel;
    }

    public function getConfig($path, $store = null)
    {
        return $this->_scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store);
    }
}
