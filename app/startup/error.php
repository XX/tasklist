<?php

function exception_error_handler($severity, $message, $file, $line)
{
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}

function exception_handler($exception)
{
    echo "Exception: " , $exception->getMessage(), "\n";
}

set_error_handler("exception_error_handler");
set_exception_handler('exception_handler');