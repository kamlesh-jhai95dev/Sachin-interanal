<?php


namespace I95Dev\CustomPrice\Observer;

use Magento\Framework\Event\ObserverInterface;
use I95Dev\CustomPrice\Controller\Index\Index;

class CustomPrice implements ObserverInterface
{

    public function __construct(
        Index $index
    ) {

        $this->index = $index;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $value = $this->index->getConfigValue();
        if ($value == Yes) {

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
