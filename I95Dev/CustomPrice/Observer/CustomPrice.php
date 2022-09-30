<?php


namespace I95Dev\CustomPrice\Observer;

use Magento\Framework\Event\ObserverInterface;

class CustomPrice implements ObserverInterface
{

    protected $scopeConfig;
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {

        $this->scopeConfig = $scopeConfig;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $value = $this->scopeConfig->getValue("pricepart/general/enable");
       // echo $value;
        if ($value == 1) {

        $item = $observer->getEvent()->getData('quote_item');


        // Get parent product if current product is child product
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);

        $product_Price = $item->getProduct()->getPrice();
        //getting product price

            $price = $product_Price + 10;
            //adding customprice

            //Set custom price
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            $item->getProduct()->setIsSuperMode(true);
        }
    }


}
?>
