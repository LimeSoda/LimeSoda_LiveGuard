<?php

class LimeSoda_LiveGuard_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Asserts that the system configuration value equals the environment
     * configuration value specified in XML for the current enviroment.
     * 
     * @throws Exception
     * @param string $variable Variable name used in the environment configuration XML
     * @param string $path System configuration path
     * @param mixed $store Store (if you want to check for a specific store-view)
     * @return void
     */
    public function assertCurrEnvConfigEqualsSysConfig($variable, $path, $store = null)
    {
        $expected = Mage::helper('limesoda_environmentconfiguration/current')->getValue($variable);
        $actual = Mage::getStoreConfig($path, $store);
        
        if ($expected != $actual) {
            throw new Exception("The value of environment configuration variable '$variable' did not match the system configuration value of '$path'" . (!is_null($store) ? " (store '$store')" : '') . ". Expected: $expected, actual: $actual");
        }
    }
}
