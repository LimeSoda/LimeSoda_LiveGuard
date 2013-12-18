<?php

class LimeSoda_LiveGuard_Model_Config
{
    const XML_PATH = 'global/limesoda/guards';
    
    protected $_config = null;
    
    protected $_guards = null;

    /**
     * Returns whether the configuration node exists.
     * 
     * @return bool
     */
    public function configExists()
    {
        return ($this->getConfig() !== false);
    }
    
    /**
     * Returns the configuration XML.
     * 
     * @return Mage_Core_Model_Config_Element|false
     */
    public function getConfig()
    {
        if ($this->_config === null) {
            $this->_config = Mage::getConfig()->getNode(self::XML_PATH);
        }
        return $this->_config;
    }

    /**
     * Returns the guards.
     * 
     * @return Array an array of guards
     */
    public function getGuards()
    {
        if ($this->_guards === null) {
            $environment = Mage::helper('limesoda_environmentconfiguration/current')->getEnvironmentName();
            
            $guards = array();
            
            foreach ($this->getConfig()->asArray() as $name => $config) {
                if (!array_key_exists('active', $config) || !array_key_exists('environments_to_omit', $config) || !array_key_exists('class', $config)) {
                    throw new InvalidArgumentException("Guard '$name' misses parts of the configuration.");    
                }
                if ($config['active'] === 'false' || in_array($environment, explode(',', $config['environments_to_omit']))) {
                    continue;
                }
                
                $modelClass = $config['class'];
                $guard = Mage::getModel($modelClass);
                
                if (!($guard instanceof LimeSoda_LiveGuard_Model_GuardInterface)) {
                    throw new InvalidArgumentException('Guard class doesn\'t implement the guard interface.');
                }
                
                $guards[] = $guard;
            }
            $this->_guards = $guards;
        } 
        
        
        return $this->_guards;
    }
    
}
