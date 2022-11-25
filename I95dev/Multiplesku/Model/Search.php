<?php

namespace I95dev\Multiplesku\Model;
 
class Search extends \Magento\CatalogSearch\Model\ResourceModel\Search\Collection
    {
        public function addBackendSearchFilter($query)
        {
            $this->_searchQuery = $query;
            $valuePart = explode(",", $query);
    
            if(count($valuePart) > 1)
            {   
                foreach ($valuePart as $value) {
                    $retStr[]= trim($value);
                  }
                $this->addFieldToFilter(
                    'sku',
                    ['in' => $retStr]
                );
            }
            else
            {
                $this->addFieldToFilter(
                    $this->getEntity()->getLinkField(),
                ['in' => new \Zend_Db_Expr($this->_getSearchEntityIdsSql($query, false))]
                );
            }
            return $this;
        }
    }
