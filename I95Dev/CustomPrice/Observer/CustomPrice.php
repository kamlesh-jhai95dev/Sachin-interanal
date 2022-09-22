<?php


namespace I95Dev\CustomPrice\Observer;

use \Magento\Framework\Event\ObserverInterface;

class CustomPrice implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');

        // Get parent product if current product is child product
        $item = ($item->getParentItem() ? $item->getParentItem() : $item);

        $product_Price = $item->getProduct()->getPrice();
        //getting product price
        $price = $product_Price+10;
        //adding customprice


        //Set custom price
        $item->setCustomPrice($price);
        $item->setOriginalCustomPrice($price);
        $item->getProduct()->setIsSuperMode(true);
    }
}
