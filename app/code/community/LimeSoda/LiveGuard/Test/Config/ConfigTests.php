<?php
/**
 * Created by Andreas Penz.
 * Date: 24.06.14
 * Time: 17:58
 */

class LimeSoda_LiveGuard_Test_Config_ConfigTests
    extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * @test
     */
    public function testCodePool()
    {
        $this->assertModuleCodePool('community');
    }

    /**
     * @test
     */
    public function testModuleIsActive()
    {
        $this->assertModuleIsActive();
    }

    /**
     * @test
     */
    public function testModuleVersion()
    {
        $this->assertModuleVersion('1.0.2');
    }

    /**
     * @test
     */
    public function testModuleDependencies()
    {
        $this->assertModuleDepends('LimeSoda_EnvironmentConfiguration');
    }

    /**
     * @test
     */
    public function testHelperAliases()
    {
        $this->assertHelperAlias(
            'limesoda_liveguard',
            'LimeSoda_LiveGuard_Helper_Data'
        );
    }

    /**
     * @test
     */
    public function testObserverDefined()
    {
        $this->assertEventObserverDefined(
            'global', 'controller_front_init_before', 'limesoda_liveguard/observer', 'controllerFrontInitBefore'
        );
    }

}
