<?php

namespace LimeSoda\LiveGuard;

/**
 * Class Error
 * @package LimeSoda\LiveGuard
 */
class Error
{

    protected $exception;
    protected $message;
    protected $firstTraceFile;

    /**
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->message = $e->getMessage();
        $this->firstTraceFile = $this->setFirstTraceFile($e);
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
        return $this->firstTraceFile;
    }

    /**
     * @return string
     */
    public  function getMessage()
    {
        return $this->message;
    }

}