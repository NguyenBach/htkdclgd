<?php
/**
 * Created by PhpStorm.
 * User: bach
 * Date: 29/08/2019
 * Time: 23:08
 */

namespace App\Log;


class LogProcessor
{
    public function __invoke(array $record)
    {
        $record['extra'] = [
            'user_id' => auth()->user() ? auth()->user()->id : NULL,
            'origin' => request()->headers->get('origin'),
            'ip' => request()->server('REMOTE_ADDR'),
            'user_agent' => request()->server('HTTP_USER_AGENT'),
            'token' => request()->bearerToken(),
            'university_id' => auth()->user()->university_id
        ];

        return $record;
    }
}