<?php

namespace I95Dev\UnitTest\Test\Unit\Model;

class CalculatorTest extends  \PHPUnit\Framework\TestCase {

    protected $_objectManager;
    protected $_desiredResult;
    protected $_actulResult;
    protected $_calculator;

    public function setUp():void{
        $this->_objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_calculator = $this->_objectManager->getObject("I95Dev\UnitTest\Model\Calculator");
        //can do stuff
    }

    public function testAddition() {
        $this->_actulResult = $this->_calculator->addition(7.0,3.0);
        $this->_desiredResult = 10.0;
        $this->assertEquals($this->_desiredResult, $this->_actulResult);
    }
}
