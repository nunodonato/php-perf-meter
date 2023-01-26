<?php

namespace Nunodonato\PhpPerfMeter;

use ReflectionClass;

class PhpPerfMeterClass
{
    public \ReflectionClass $reflected;
    public $object;
    public function __construct(object $object)
    {
        $this->object = $object;
        $this->reflected = new ReflectionClass($object);
    }

    public function __call($method, $args): mixed
    {
        $method = $this->reflected->getMethod($method);
        $method->setAccessible(true);

        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        $result = $method->invoke($this->object, $args);

        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $totalTime = $endTime - $startTime;
        $totalMemory = $endMemory - $startMemory;



        return $result;
    }
}
