<?php

namespace App\Repository;

use App\Entity\AcquiringSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AcquiringSettings>
 *
 * @method AcquiringSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcquiringSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcquiringSettings[]    findAll()
 * @method AcquiringSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcquiringSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcquiringSettings::class);
    }

    public function save(AcquiringSettings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AcquiringSettings $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
