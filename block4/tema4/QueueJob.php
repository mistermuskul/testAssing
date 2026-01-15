<?php

class QueueJob
{
    private $message;
    private $logFile;

    public function __construct($message)
    {
        $this->message = $message;
        $this->logFile = __DIR__ . '/queue.log';
    }

    public function handle()
    {
        $logMessage = date('Y-m-d H:i:s') . " - " . $this->message . "\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
        echo "Job processed: " . $this->message . "\n";
    }
}

