<?php

require_once __DIR__ . '/vendor/autoload.php';

use Predis\Client;

class RedisQueue
{
    private $redis;
    private $queueName;

    public function __construct($queueName = 'default')
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host' => '127.0.0.1',
            'port' => 6379,
        ]);
        $this->queueName = $queueName;
    }

    public function push($job)
    {
        $data = serialize($job);
        $this->redis->rpush($this->queueName, $data);
    }

    public function pop()
    {
        $data = $this->redis->blpop([$this->queueName], 0);
        if ($data) {
            return unserialize($data[1]);
        }
        return null;
    }

    public function work()
    {
        echo "Queue worker started. Waiting for jobs...\n";
        while (true) {
            $job = $this->pop();
            if ($job) {
                $job->handle();
            }
        }
    }
}

