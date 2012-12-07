<?php

use Hautelook\Phpass\PasswordHash;

$di->setService(
    'phpass',
    function () {
        return new PasswordHash(8, false);
    }
);