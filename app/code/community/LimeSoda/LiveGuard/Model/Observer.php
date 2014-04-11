<?php

class LimeSoda_LiveGuard_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     * @return LimeSoda_LiveGuard_Model_Observer
     */
    public function controllerFrontInitBefore(Varien_Event_Observer $observer)
    {
        $config = Mage::getModel('limesoda_liveguard/config');
        
        if (!$config->configExists()) {
            return $this;
        }
        
        $guards = array();
        foreach ($config->getGuards() as $guard)
        {
            if( $guard->hasAutoSwitch() && $guard->getAutoSwitch() ) $guard->autoSwitch();
            $guard->process();
        }

        return $this;
    }
}
