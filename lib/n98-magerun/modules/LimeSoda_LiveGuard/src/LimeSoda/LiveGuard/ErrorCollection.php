<?php

namespace LimeSoda\LiveGuard;
use LimeSoda\LiveGuard\Error;

/**
 * Class ErrorCollection
 * @package LimeSoda\LiveGuard
 */
class ErrorCollection
{

    protected $exceptions = array();

    /**
     * @param \Exception $exception
     */
    public function addError( \Exception $exception )
    {
        $this->exceptions[] = new Error($exception);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->exceptions;
    }

    /**
     * @return int
     */
    public function countErrors()
    {
        return count($this->exceptions);
    }
}
