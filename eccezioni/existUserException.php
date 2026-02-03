<?php

namespace app\eccezioni;

use Exception;

class existUserException extends Exception
{
    public function getName()
    {
        return 'ustente gia\' esistente';
    }
}

?>