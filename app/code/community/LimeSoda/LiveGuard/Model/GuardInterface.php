<?php

interface LimeSoda_LiveGuard_Model_GuardInterface
{
    /**
     * Processes the check.
     * 
     * Throws an exception if the check fails.
     * 
     * @throws Exception
     * @return void
     */
    public function process();
}
