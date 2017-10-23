<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Workshop;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository implements UserLoaderInterface
{

    public function loadUserByUsername($username)
    {
        $user = $this->createQueryBuilder('u')
            ->where('u.phone1 = :mobile_phone OR u.email = :email')
            ->andWhere('u.removed_at IS NULL')
            ->andWhere('u.deleted_at IS NULL')
            ->setParameter(':mobile_phone', $username)
            ->setParameter(':email', $username)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }

    public function getOne(Workshop $workshop, $id, $hydrationMode = Query::HYDRATE_OBJECT)
    {
        $vehicle = $this->_em
            ->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.deleted_at IS NULL')
            ->andWhere('u.removed_at IS NULL')
            ->andWhere('u.workshop = :workshop')
            ->andWhere('u.id = :id')
            ->setParameters([
                ':workshop' => $workshop,
                ':id'       => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult($hydrationMode)
        ;

        return $vehicle;
    }

    public function retrieve(Workshop $workshop, $sortableParameters = [])
    {
        $search     = $sortableParameters['search'];
        $limit      = (int) $sortableParameters['limit'];
        $offset     = (int) $sortableParameters['offset'];
        $sortOrder  = $sortableParameters['sortOrder'];
        $sortColumnName = $sortableParameters['sortColumnName'];
        //$systemFilters  = $sortableParameters['systemFilters'];
        // $customFilters  = $sortableParameters['customFilters'];

        $queryBuilder = $this->_em
            ->createQueryBuilder()
            ->select('u')
            ->from('AppBundle:User', 'u')
            ->leftJoin('AppBundle:Address', 'a', 'WITH', 'u.address_id = a.id')
            ->leftJoin('AppBundle:Province', 'p', 'WITH', 'a.province_id = p.id')
            ->innerJoin('u.workshops', 'workshops')
          ;

        $users = $queryBuilder
            ->andWhere('u.deleted_at IS NULL')
            ->andWhere('u.removed_at IS NULL')
            ->andWhere('workshops IN (:workshops)')
            ->andWhere("
                    CONCAT_WS(' ', u.forename, u.surname, u.email) LIKE :search
                OR  CONCAT_WS(' ', u.phone1, u.phone2) LIKE :search
                OR  CONCAT_WS(' ', u.nip, u.pesel) LIKE :search
                OR  CONCAT_WS(' ', u.bank_account_number, u.remarks) LIKE :search
                OR  CONCAT_WS(' ', a.street, a.post_code, a.city, p.name) LIKE :search
            ")
            ->orderBy($sortColumnName, $sortOrder)
            ->addOrderBy('u.updated_at', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->groupBy('u.id')
            ->setParameter(':workshops', [$workshop])
            ->setParameter(':search', '%' . $search . '%')
            ->getQuery()
            ->getResult()
        ;

        return $users;
    }

    public function getCountAllRetrieved(Workshop $workshop, $sortableParameters = [])
    {
        $search     = $sortableParameters['search'];
        $sortOrder  = $sortableParameters['sortOrder'];
        $sortColumnName = $sortableParameters['sortColumnName'];
        //$systemFilters  = $sortableParameters['systemFilters'];
        //$customFilters  = $sortableParameters['customFilters'];


        $queryBuilder = $this->_em
            ->createQueryBuilder()
            ->select('COUNT(u)')
            ->from('AppBundle:User', 'u')
            ->leftJoin('AppBundle:Address', 'a', 'WITH', 'u.address_id = a.id')
            ->leftJoin('AppBundle:Province', 'p', 'WITH', 'a.province_id = p.id')
            ->innerJoin('u.workshops', 'workshops')
        ;


        $countUsers = $queryBuilder
            ->andWhere('u.deleted_at IS NULL')
            ->andWhere('u.removed_at IS NULL')
            ->andWhere('workshops IN (:workshops)')
            ->andWhere("
                    CONCAT_WS(' ', u.forename, u.surname, u.email) LIKE :search
                OR  CONCAT_WS(' ', u.phone1, u.phone2) LIKE :search
                OR  CONCAT_WS(' ', u.nip, u.pesel) LIKE :search
                OR  CONCAT_WS(' ', u.bank_account_number, u.remarks) LIKE :search
                OR  CONCAT_WS(' ', a.street, a.post_code, a.city, p.name) LIKE :search
            ")
            ->orderBy($sortColumnName, $sortOrder)
            ->addOrderBy('u.updated_at', 'DESC')
            ->setParameter(':workshops', [$workshop])
            ->setParameter(':search', '%' . $search . '%')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $countUsers;
    }

}
