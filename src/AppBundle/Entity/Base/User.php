<?php

namespace AppBundle\Entity\Base;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class User implements UserInterface, \Serializable
{

    private $username;

    public function getUsername()
    {

        return $this->username;
    }
    public function getSalt()
    {
        return null;
    }
    public function eraseCredentials()
    {
    }
    public function serialize()
    {
        return serialize([
            $this->getId(),
            $this->username,
            $this->getPassword(),
        ]);
    }
    public function unserialize($serialized)
    {
        $id = $this->getId();
        $password = $this->getPassword();

        list(
            $id,
            $this->username,
            $password,
            ) = unserialize($serialized);
    }

    /**
     * @param $secret
     * @return mixed
     */
    public function getHashCode($secret)
    {
        $stringToHash = (string) $this->getId() . $this->getCreatedAt()->format('Y-m-d-H-i-j');

        $salt = '$6$' . $secret;

        return str_replace('/', '-', crypt($stringToHash, $salt));
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
}