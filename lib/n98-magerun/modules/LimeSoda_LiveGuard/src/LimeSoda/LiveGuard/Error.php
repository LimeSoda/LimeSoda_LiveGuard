<?php

namespace LimeSoda\LiveGuard;

/**
 * Class Error
 * @package LimeSoda\LiveGuard
 */
class Error
{

    protected $_exception;
    protected $_message;
    protected $_firstTraceFile;

    /**
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->_message = $e->getMessage();
        $this->_firstTraceFile = $this->setFirstTraceFile($e);
    }

    /**
     * @param \Exception $exception
     * @return mixed
     */
    protected function setFirstTraceFile(\Exception $exception)
    {
        foreach ($exception->getTrace() as $trace) {
            return $trace['file'];
        }
    }

    /**
     * @return string
     */
    public function getFirstTraceFile()
    {
        return $this->_firstTraceFile;
    }

    /**
     * @return string
     */
    public  function getMessage()
    {
        return $this->_message;
    }

}
