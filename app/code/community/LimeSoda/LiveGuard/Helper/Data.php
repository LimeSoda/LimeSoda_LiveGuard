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
            throw new Exception("The value in the environment configuration XML for '$variable' did not match the value in '$path'. Expected: $expected, actual: $actual");
        }
    }
}
