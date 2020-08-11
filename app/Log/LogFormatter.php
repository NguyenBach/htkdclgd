<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 30/08/2019
 * Time: 22:15
 */

namespace App\Log;


use Illuminate\Http\Request;
use Monolog\Formatter\NormalizerFormatter;

class LogFormatter extends NormalizerFormatter
{
    /**
     * type
     */
    const LOG = 'log';
    const STORE = 'store';
    const CHANGE = 'change';
    const DELETE = 'delete';
    /**
     * result
     */
    const SUCCESS = 'success';
    const NEUTRAL = 'neutral';
    const FAILURE = 'failure';

    public function __construct()
    {
        parent::__construct();
    }


    public function format(array $record)
    {
        $record = parent::format($record);
        return $this->getDocument($record);
    }


    protected function getDocument(array $record)
    {
        $fills = $record['extra'];
        $fills['level'] = strtolower($record['level_name']);
        $fills['description'] = $record['message'];
        $context = $record['context'];
        if (!empty($context)) {
            $fills['type'] = key_exists('type',$context) ? $context['type'] : self::LOG;
            $fills['result'] = key_exists('result',$context) ? $context['result'] : self::NEUTRAL;
            $fills = array_merge($record['context'], $fills);
        }
         return $fills;
    }
}