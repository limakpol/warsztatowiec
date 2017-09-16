<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/16/17
 * Time: 6:40 PM
 */

namespace AppBundle\Entity\Base;


use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

abstract class UserRole implements RoleHierarchyInterface
{

    const ROLE_USER = 'ROLE_USER';

    public function getReachableRoles(array $roles)
    {

    }
}