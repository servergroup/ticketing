<?php
namespace app\eccezioni;
use Exception;
class tentativiSuperati extends Exception
{
    public function getName()
    {
        return 'blocco superato';
    }
}
?>