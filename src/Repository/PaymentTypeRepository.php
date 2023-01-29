<?php

namespace App\Repository;

use App\Component\Exception\RepositoryException;
use App\Entity\PaymentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @extends ServiceEntityRepository<PaymentType>
 *
 * @method PaymentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentType[]    findAll()
 * @method PaymentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentType::class);
    }

    public function save(PaymentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PaymentType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Получить тип оплаты по коду
     *
     * @param string|null $code
     * @return PaymentType
     * @throws RepositoryException
     */
    public function getPaymentTypeByCode(?string $code): PaymentType
    {
        $paymentType = $this->findOneBy(['code' => $code]);

        if (null === $paymentType) {
            throw new RepositoryException(
                message: 'Не найден тип оплаты с кодом: ' . $code,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'PAYMENT_TYPE_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        return $paymentType;
    }
}
