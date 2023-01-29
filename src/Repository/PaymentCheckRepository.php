<?php

namespace App\Repository;

use App\Entity\PaymentCheck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentCheck>
 *
 * @method PaymentCheck|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentCheck|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentCheck[]    findAll()
 * @method PaymentCheck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentCheckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentCheck::class);
    }

    public function save(PaymentCheck $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentCheck $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
