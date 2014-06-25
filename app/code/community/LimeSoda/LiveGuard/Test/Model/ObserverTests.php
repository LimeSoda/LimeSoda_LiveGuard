<?php
/**
 * Created by Andreas Penz.
 * Date: 24.06.14
 * Time: 21:53
 */

class LimeSoda_LiveGuard_Test_Model_ObserverTests
    extends EcomDev_PHPUnit_Test_Case_Config
{


    /**
     * @return Mage_Core_Model_Abstract
     */
    protected function _getObserverInstance()
    {
        return Mage::getModel('limesoda_liveguard/observer');
    }

    /**
     * @return Varien_Event_Observer
     */
    protected function _getVarienEventObserverMock()
    {
        return $this->getMock('Varien_Event_Observer');
    }

    /**
     * @test
     */
    public function testControllerFrontInitBeforeNoConfigExists()
    {
        $observer = $this->_getObserverInstance()->controllerFrontInitBefore($this->_getVarienEventObserverMock());
        $this->assertInstanceOf('LimeSoda_LiveGuard_Model_Observer', $observer);
    }

    /**
     * @test
     */
    public function testControllerFrontInitBefore()
    {
        $mock = $this->getModelMock('limesoda_liveguard/config', array('configExists', 'getGuards'));

        $mock->expects($this->once())
            ->method('configExists')
            ->will($this->returnValue(true));

        $fourthGuardMock = $this->getMock('Fourth_Guard_Class', array('process'));

        $fourthGuardMock->expects($this->once())
            ->method('process');

        $this->replaceByMock('model', 'fourth_guard/class', $fourthGuardMock);

        $fifthGuardMock = $this->getMock('Second_Guard_Class');

        $fifthGuardMock->expects($this->once())
            ->method('process');

        $this->replaceByMock('model', 'second_guard/class', $fifthGuardMock);

        $mock->expects($this->once())
            ->method('getGuards')
            ->will($this->returnValue(array( $fourthGuardMock, $fifthGuardMock)));

        $this->replaceByMock('model', 'limesoda_liveguard/config', $mock);

        $observer = $this->_getObserverInstance()->controllerFrontInitBefore($this->_getVarienEventObserverMock());

        $this->assertInstanceOf('LimeSoda_LiveGuard_Model_Observer', $observer);
    }
}

class Fourth_Guard_Class
    implements LimeSoda_LiveGuard_Model_GuardInterface
{
    public function process()
    {

    }
}

class Fifth_Guard_Class
    implements LimeSoda_LiveGuard_Model_GuardInterface
{
    public function process()
    {

    }
}