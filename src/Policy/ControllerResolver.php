<?php
namespace App\Policy;

use Authorization\Policy\ResolverInterface;
use Authorization\Policy\Exception\MissingPolicyException;
use Cake\Controller\Controller;

class ControllerResolver implements ResolverInterface
{
    public function getPolicy($resource)
    {
        if ($resource instanceof Controller) {
            return new ControllerHookPolicy();
        }

        throw new MissingPolicyException([get_class($resource)]);
    }
}