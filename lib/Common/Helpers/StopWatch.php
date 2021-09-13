<?php

class StopWatch
{
    /**
     * @var float
     */
    private $startTime;

    /**
     * @var float
     */
    private $stopTime;

    /**
     * @var array|float[]
     */
    private $times = [];

    public function Start()
    {
        $this->startTime = microtime(true);
    }

    /**
     * @return StopWatch
     */
    public static function StartNew()
    {
        $sw = new StopWatch();
        $sw->Start();
        return $sw;
    }

    public function Stop()
    {
        $this->stopTime = microtime(true);
    }

    /**
     * @param string $label
     */
    public function Record($label)
    {
        $this->times[$label] = microtime(true);
    }

    /**
     * @param string $label
     * @return float
     */
    public function GetRecordSeconds($label)
    {
        return $this->times[$label] - $this->startTime;
    }

    /**
     * @param string $label1
     * @param string $label2
     * @return float
     */
    public function TimeBetween($label1, $label2)
    {
        return $this->times[$label1] - $this->times[$label2];
    }

    /**
     * @return float
     */
    public function GetTotalSeconds()
    {
        return $this->stopTime - $this->startTime;
    }
}
