<?php
namespace App\Example;

class MonologExample implements SandboxExample
{
    private Logger $log;

    public function run()
    {
        $this->log = new Logger("PhpSandbox");
        $this->log->pushHandler(new StreamHandler('var/log/app.log', Logger::WARNING));
        $this->log->warning('Starting App');
    }

    public function __destruct()
    {
        $this->log->warning('Closing App');
    }
}