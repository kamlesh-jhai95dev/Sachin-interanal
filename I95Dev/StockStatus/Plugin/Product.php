<?php

namespace I95Dev\StockStatus\Plugin;

class Product
{
public function afterGetProduct(\Magento\Catalog\Model\Product $subject, $result)
    {
     $stock = $block->getProductStatus();


if($stock==1){
    echo "In stock123";
}
else{
    echo "Out of stock";
}
    }

   

} 
