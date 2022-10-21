<?php

namespace I95Dev\Restrictaddtocart\Observer;

use Magento\Framework\Event\ObserverInterface;

class RestrictAddToCart implements ObserverInterface
{

    protected $_messageManager;
    protected $_customerSessionFactory;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Customer\Model\SessionFactory $customerSessionFactory
    )
    {
        $this->_messageManager = $messageManager;
        $this->_customerSessionFactory = $customerSessionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        // check customer login or not
        $customerSession = $this->_customerSessionFactory->create();
        if($customerSession->isLoggedIn()) {
            $this->_messageManager->addError(__('customer logged in unable to add to cart'));
            //set false if you not want to add product to cart
            $observer->getRequest()->setParam('product', false);
            return $this;
        }

    }
}
