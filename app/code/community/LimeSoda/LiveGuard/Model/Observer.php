<?php

class LimeSoda_LiveGuard_Model_Observer
{
    /**
     * @SuppressWarnings("UnusedFormalParameter")
     * @param Varien_Event_Observer $observer
     * @return LimeSoda_LiveGuard_Model_Observer
     */
    public function controllerFrontInitBefore(Varien_Event_Observer $observer)
    {
        $config = Mage::getModel('limesoda_liveguard/config');
        
        if (!$config->configExists()) {
            return $this;
        }
        
        foreach ($config->getGuards() as $guard) {
                $guard->process();
        }
        
        return $this;
    }
}
