<?php

namespace EZ\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EZUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
