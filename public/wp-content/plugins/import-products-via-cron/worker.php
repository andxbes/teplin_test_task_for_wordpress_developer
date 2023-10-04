<?php

namespace IPVC;

class Worker
{
    public function __construct()
    {
        $this->run();
    }


    protected function run()
    {
        error_log('run');
    }
}
