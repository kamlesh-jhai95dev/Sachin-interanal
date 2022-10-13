<?php
namespace I95Dev\CustomShipping\Model\Carrier;

class Ups
{
    protected $_scopeConfig;
    protected $_customerSession;
    protected $_rateResultFactory;
    protected $_resultMethodFactory;
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\OfflineShipping\Model\Carrier\Tablerate $tablerate,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $resultMethodFactory,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->tablerate = $tablerate;
        $this->_rateResultFactory = $rateResultFactory;
        $this->productFactory = $productFactory;
        $this->_resultMethodFactory = $resultMethodFactory;
        $this->_customerSession = $customerSession;
    }

    public function afterCollectRates(\Magento\Ups\Model\Carrier $subject, $result, $request)
    {
        $shippingPrice = 50;
        foreach ($result->getAllRates() as $method) {
           // $newPrice = $method->getPrice();
            $newPrice = 15.99;
            $method->setPrice($newPrice);
        }
        //return false; //if you want to disable it
        return $result;
    }
}
?>
