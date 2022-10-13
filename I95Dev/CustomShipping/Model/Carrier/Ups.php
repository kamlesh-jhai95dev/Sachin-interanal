<?php
namespace I95Dev\CustomShipping\Model\Carrier;

class Ups
{
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
    public function afterParseXmlResponse($xmlResponse)

    {
        $costArr = [];
        $priceArr = [];
        if (strlen(trim($xmlResponse)) > 0) {
            $xml = new \Magento\Framework\Simplexml\Config();
            $xml->loadString($xmlResponse);
            $arr = $xml->getXpath("//RatingServiceSelectionResponse/Response/ResponseStatusCode/text()");
            $success = (int)$arr[0];
            if ($success === 1) {
                $arr = $xml->getXpath("//RatingServiceSelectionResponse/RatedShipment");
                $allowedMethods = explode(",", $this->getConfigData('allowed_methods'));

                // Negotiated rates
                $negotiatedArr = $xml->getXpath("//RatingServiceSelectionResponse/RatedShipment/NegotiatedRates");
                $negotiatedActive = $this->getConfigFlag('negotiated_active')
                    && $this->getConfigData('shipper_number')
                    && !empty($negotiatedArr);

                $allowedCurrencies = $this->_currencyFactory->create()->getConfigAllowCurrencies();
                foreach ($arr as $shipElement) {
                    $this->processShippingRateForItem(
                        $shipElement,
                        $allowedMethods,
                        $allowedCurrencies,
                        $costArr,
                        $priceArr,
                        $negotiatedActive,
                        $xml
                    );
                }
            } else {
                $arr = $xml->getXpath("//RatingServiceSelectionResponse/Response/Error/ErrorDescription/text()");
                $errorTitle = (string)$arr[0][0];
                $error = $this->_rateErrorFactory->create();
                $error->setCarrier('ups');
                $error->setCarrierTitle($this->getConfigData('title'));
                $error->setErrorMessage($this->getConfigData('specificerrmsg'));
            }
        }

        $result = $this->_rateFactory->create();

        if (empty($priceArr)) {
            $error = $this->_rateErrorFactory->create();
            $error->setCarrier('ups');
            $error->setCarrierTitle($this->getConfigData('title'));
            if ($this->getConfigData('specificerrmsg') !== '') {
                $errorTitle = $this->getConfigData('specificerrmsg');
            }
            if (!isset($errorTitle)) {
                $errorTitle = __('Cannot retrieve shipping rates');
            }
            $error->setErrorMessage($errorTitle);
            $result->append($error);
        } else {
            foreach ($priceArr as $method => $price) {
                $rate = $this->_rateMethodFactory->create();
                $rate->setCarrier('ups');
                $rate->setCarrierTitle($this->getConfigData('title'));
                $rate->setMethod($method);
                $methodArr = $this->getShipmentByCode($method);
                $rate->setMethodTitle($methodArr);
                $rate->setCost($costArr[$method]);
//                if($method == '3')
//                {
                    $rate->setPrice("15.99");
//                }else{
//                    $rate->setPrice($price);
//                }
                $result->append($rate);
            }
        }

        return $result;
    }
}
?>
