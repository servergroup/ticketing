<?php
namespace app\eccezioni;

use Exception;

class dataException extends Exception
{
    public function getName()
    {
        return 'La data inserita risulta essere nel passato';
    }
}
?>