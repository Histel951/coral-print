<?php

namespace App\Services\Calculator\Count\Algorithms;

trait LoggerTrait
{
    protected bool $debug = false;

    protected bool $managerIn = false;

    protected array $debugLog = [];

    /**
     * @param string $error
     */
    protected function setError(string $error): void
    {
        $this->setDebugLog('ERROR: ' . $error);
    }

    /**
     * @return Calculator
     */
    public function debugOn(): Calculator
    {
        $this->debug = true;

        return $this;
    }

    /**
     * @param string $msg
     * @param bool   $time
     */
    protected function setDebugLog(string $msg, bool $time = true): void
    {
        if ($time) {
            $this->debugLog[] = $msg;
        } else {
            $this->debugLog[] = $msg;
        }
    }

    /**
     * Starts calculator program timer
     */
    protected function startTime(): void
    {
        $this->timeStart = microtime(true);
        $this->setDebugLog('Started ' . get_class($this), false);
    }

    /**
     * Checks manager login
     */
    protected function checkManager(): void
    {
        switch ($_SESSION['usertype']) {
            case 'manager':
                $this->managerIn = true;
                $this->setDebugLog('Manager in', false);
                break;
            default:
                $this->managerIn = false;
                $this->setDebugLog('Manager out', false);
                break;
        }
    }
}
