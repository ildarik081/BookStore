<?php

namespace App\Repository;

use App\Entity\HistoryOrderStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistoryOrderStatus>
 *
 * @method HistoryOrderStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoryOrderStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoryOrderStatus[]    findAll()
 * @method HistoryOrderStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryOrderStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoryOrderStatus::class);
    }

    public function save(HistoryOrderStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistoryOrderStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
