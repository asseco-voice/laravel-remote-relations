<?php

namespace Voice\RemoteRelations\App\Exceptions;

use Exception;
use Throwable;

class RemoteRelationException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("[RemoteRelations] $message", $code, $previous);
    }

}
