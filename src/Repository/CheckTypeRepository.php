<?php

namespace App\Repository;

use App\Component\Exception\RepositoryException;
use App\Entity\CheckType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @extends ServiceEntityRepository<CheckType>
 *
 * @method CheckType|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckType|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckType[]    findAll()
 * @method CheckType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckType::class);
    }

    public function save(CheckType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CheckType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Получить тип чека по коду
     *
     * @param string $code
     * @return CheckType
     * @throws RepositoryException
     */
    public function getCheckTypeByCode(string $code): CheckType
    {
        $checkType = $this->findOneBy(['code' => $code]);

        if (null === $checkType) {
            throw new RepositoryException(
                message: 'Не найден тип чека с кодом: ' . $code,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'CHECK_TYPE_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        return $checkType;
    }
}
