<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 29/08/2019
 * Time: 23:05
 */

namespace App\Log;


use Modules\System\Entities\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class LogHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level);
    }

    protected function write(array $record)
    {
        // Simple store implementation
        $log = new Log();
        $log->fill($record['formatted']);
        $log->save();
        // Queue implementation
        //// event(new LogMonologEvent($record));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new LogFormatter();
    }
}