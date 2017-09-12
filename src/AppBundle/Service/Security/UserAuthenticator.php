<?php
namespace AppBundle\Service\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimpleFormAuthenticatorInterface;

class UserAuthenticator implements SimpleFormAuthenticatorInterface
{
    private $encoder;
    private $entityManager;
    public function __construct(UserPasswordEncoderInterface $encoder, EntityManager $entityManager)
    {
        $this->encoder          = $encoder;
        $this->entityManager    = $entityManager;
    }
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        try
        {
            /** @var User $user */
            $user = $userProvider->loadUserByUsername($token->getUsername());
        }
        catch (UsernameNotFoundException $e)
        {
            throw new CustomUserMessageAuthenticationException('Invalid username or password');
        }
        $passwordValid = $this->encoder->isPasswordValid($user, $token->getCredentials());
        if($passwordValid)
        {
            if(null == $user->getCurrentWorkshop())
            {
                $workshop = $user->getWorkshops()->first();
                $user->setCurrentWorkshop($workshop);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
            return new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                $providerKey,
                $user->getRoles()->toArray()
            );
        }
        throw new CustomUserMessageAuthenticationException('Invalid username or password');
    }
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof UsernamePasswordToken && $token->getProviderKey() === $providerKey;
    }
    public function createToken(Request $request, $username, $password, $providerKey)
    {
        return new UsernamePasswordToken($username, $password, $providerKey);
    }
}