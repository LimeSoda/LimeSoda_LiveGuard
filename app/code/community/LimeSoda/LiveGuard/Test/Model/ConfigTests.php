<?php
/**
 * Created by Andreas Penz.
 * Date: 24.06.14
 * Time: 18:07
 */

class LimeSoda_LiveGuard_Test_Model_ConfigTests
    extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * @return false|Mage_Core_Model_Abstract
     */
    protected function _getConfigInstance()
    {
        return Mage::getModel('limesoda_liveguard/config');
    }

    /**
     * @test
     */
    public function testConfigExists()
    {

        $mock = $this->getModelMock('limesoda_liveguard/config', array('getConfig'));

        $mock->expects($this->once())
            ->method('getConfig')
            ->will($this->returnValue(array()));

        $this->replaceByMock('model', 'limesoda_liveguard/config', $mock);

        $configExists = $this->_getConfigInstance()->configExists();

        $this->assertTrue($configExists);

    }

    /**
     * @test
     * @loadFixture
     * @loadExpectation
     */
    public function testGetConfig()
    {
        $config = $this->_getConfigInstance()->getConfig();

        $this->assertNotNull($config);

        $this->assertInstanceOf('Mage_Core_Model_Config_Element', $config);

        $this->assertSame(
            $config->asArray(),
            $this->expected()->getData()
        );

    }

    /**
     * @param $name
     */
    protected function _mockGetEnvironmentName( $name )
    {

        $mock = $this->getHelperMock('limesoda_environmentconfiguration/current', array('getEnvironmentName'));

        $mock->expects($this->any())
            ->method('getConfig')
            ->will($this->returnValue($name));

        $this->replaceByMock('helper', 'limesoda_environmentconfiguration/current', $mock);

    }

    /**
     * @test
     * @loadFixture
     * @expectedException InvalidArgumentException
     */
    public function testGetGuardsMissesArguments()
    {
        $this->_mockGetEnvironmentName('dev');
        $this->_getConfigInstance()->getGuards();
    }

    /**
     * @test
     * @loadFixture
     */
    public function testGetGuardsSkipGuards()
    {
        $this->_mockGetEnvironmentName('dev');
        $guards = $this->_getConfigInstance()->getGuards();
        $this->assertEmpty($guards);
    }

    /**
     * @test
     * @loadFixture
     * @expectedException InvalidArgumentException
     */
    public function testGetGuardsGuardModelDoesNotImplementInterface()
    {
        $mock = $this->getMock('First_Guard_Class');
        $this->replaceByMock('model', 'first_guard/class', $mock);

        $this->_mockGetEnvironmentName('dev');
        $this->_getConfigInstance()->getGuards();

    }

    /**
     * @loadFixture
     */
    public function testGetGuards()
    {
        $secondGuardMock = $this->getMock('Second_Guard_Class');
        $this->replaceByMock('model', 'second_guard/class', $secondGuardMock);

        $thirdGuardMock = $this->getMock('Third_Guard_Class');
        $this->replaceByMock('model', 'third_guard/class', $thirdGuardMock);

        $this->_mockGetEnvironmentName('staging');
        $guards = $this->_getConfigInstance()->getGuards();

        $this->assertEquals(2, count($guards));

        $this->assertInstanceOf(get_class($secondGuardMock), $guards[0]);

        $this->assertInstanceOf(get_class($thirdGuardMock), $guards[1]);

    }

}

class First_Guard_Class
{
}

class Second_Guard_Class
    implements LimeSoda_LiveGuard_Model_GuardInterface
{
    public function process()
    {

    }
}

class Third_Guard_Class
    implements LimeSoda_LiveGuard_Model_GuardInterface
{
    public function process()
    {

    }
}
