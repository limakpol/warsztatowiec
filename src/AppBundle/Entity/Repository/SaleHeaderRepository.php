<?php

namespace AppBundle\Entity\Repository;
use AppBundle\Entity\Workshop;

/**
 * SaleHeaderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaleHeaderRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCount(Workshop $workshop, $documentType, $numberingMode)
    {
        $queryBuilder = $this->_em->createQueryBuilder()
            ->select('COUNT(s)')
            ->from('AppBundle:SaleHeader', 's')
            ->where('s.workshop = :workshop')
            ->andWhere('s.document_type = :documentType')
            ->andWhere('s.removed_at IS NULL')
            ->andWhere('s.deleted_at IS NULL')
            ;

        if($numberingMode == 'monthly')
        {
            $queryBuilder
                ->andWhere('MONTH(s.created_at) = :month')
                ->andWhere('YEAR(s.created_at) = :year')
                ->setParameter(':month', date('m'))
                ->setParameter(':year', date('Y'))
                ;
        }
        elseif($numberingMode == 'yearly')
        {
            $queryBuilder
                ->andWhere('YEAR(s.created_at) = :year')
                ->setParameter(':year', date('Y'))
            ;
        }
        else
        {
            return null;
        }

        $count = $queryBuilder
            ->setParameter(':workshop', $workshop)
            ->setParameter(':documentType', $documentType)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $count;
    }

    public function getOne(Workshop $workshop, $id, $hydrationMode = Query::HYDRATE_OBJECT)
    {
        $saleHeader = $this->_em
            ->createQueryBuilder()
            ->select('d')
            ->from('AppBundle:SaleHeader', 'd')
            ->where('d.deleted_at IS NULL')
            ->andWhere('d.removed_at IS NULL')
            ->andWhere('d.workshop = :workshop')
            ->andWhere('d.id = :id')
            ->setParameters([
                ':workshop' => $workshop,
                ':id'       => $id,
            ])
            ->getQuery()
            ->getOneOrNullResult($hydrationMode)
        ;

        return $saleHeader;
    }

    public function retrieve(Workshop $workshop, $sortableParameters = [])
    {
        $search     = $sortableParameters['search'];
        $limit      = (int) $sortableParameters['limit'];
        $offset     = (int) $sortableParameters['offset'];
        $sortOrder  = $sortableParameters['sortOrder'];
        $sortColumnName = $sortableParameters['sortColumnName'];
        $systemFilters  = $sortableParameters['systemFilters'];
        $customFilters  = $sortableParameters['customFilters'];

        $queryBuilder = $this->_em
            ->createQueryBuilder()
            ->select('d')
            ->from('AppBundle:SaleHeader', 'd')
            ->leftJoin('AppBundle:Customer', 'c', 'WITH', 'd.customer_id = c.id')
            ->leftJoin('AppBundle:Address', 'a', 'WITH', 'c.address_id = a.id')
            ->leftJoin('AppBundle:Province', 'p', 'WITH', 'a.province_id = p.id')
        ;

        $saleHeaders = $queryBuilder
            ->andWhere('d.deleted_at IS NULL')
            ->andWhere('d.removed_at IS NULL')
            ->andWhere('d.workshop = :workshop')
            ->andWhere("
                    CONCAT_WS(' ', c.forename, c.surname, c.company_name) LIKE :search
                OR  CONCAT_WS(' ', a.street, a.house_number, a.flat_number, a.post_code, a.city, p.name) LIKE :search
                OR  CONCAT_WS(' ', c.mobile_phone1, c.mobile_phone2, c.landline_phone, c.email) LIKE :search
                OR  CONCAT_WS(' ', c.nip, c.pesel, c.bank_account_number) LIKE :search
                OR  CONCAT_WS(' ', c.contact_person, c.remarks) LIKE :search
                OR  CONCAT_WS(' ', d.document_type, d.remarks) LIKE :search
            ")
            ->orderBy($sortColumnName, $sortOrder)
            ->addOrderBy('d.updated_at', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->groupBy('d.id')
            ->setParameter(':workshop', $workshop)
            ->setParameter(':search', '%' . $search . '%')
            ->getQuery()
            ->getResult()
        ;

        return $saleHeaders;
    }

    public function getCountAllRetrieved(Workshop $workshop, $sortableParameters = [])
    {
        $search     = $sortableParameters['search'];
        $sortOrder  = $sortableParameters['sortOrder'];
        $sortColumnName = $sortableParameters['sortColumnName'];
        $systemFilters  = $sortableParameters['systemFilters'];
        $customFilters  = $sortableParameters['customFilters'];

        $queryBuilder = $this->_em
            ->createQueryBuilder()
            ->select('COUNT(d)')
            ->from('AppBundle:SaleHeader', 'd')
            ->leftJoin('AppBundle:Customer', 'c', 'WITH', 'd.customer_id = c.id')
            ->leftJoin('AppBundle:Address', 'a', 'WITH', 'c.address_id = a.id')
            ->leftJoin('AppBundle:Province', 'p', 'WITH', 'a.province_id = p.id')
        ;

        $countSaleHeaders = $queryBuilder
            ->andWhere('d.deleted_at IS NULL')
            ->andWhere('d.removed_at IS NULL')
            ->andWhere('d.workshop = :workshop')
            ->andWhere("
                    CONCAT_WS(' ', c.forename, c.surname, c.company_name) LIKE :search
                OR  CONCAT_WS(' ', a.street, a.house_number, a.flat_number, a.post_code, a.city, p.name) LIKE :search
                OR  CONCAT_WS(' ', c.mobile_phone1, c.mobile_phone2, c.landline_phone, c.email) LIKE :search
                OR  CONCAT_WS(' ', c.nip, c.pesel, c.bank_account_number) LIKE :search
                OR  CONCAT_WS(' ', c.contact_person, c.remarks) LIKE :search
                OR  CONCAT_WS(' ', d.document_type, d.remarks) LIKE :search
            ")
            ->orderBy($sortColumnName, $sortOrder)
            ->addOrderBy('d.updated_at', 'DESC')
            ->setParameter(':workshop', $workshop)
            ->setParameter(':search', '%' . $search . '%')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return $countSaleHeaders;
    }
    
}
