<?php

namespace App\Repository;

use App\Component\Exception\RepositoryException;
use App\Entity\OrderStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @extends ServiceEntityRepository<OrderStatus>
 *
 * @method OrderStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderStatus[]    findAll()
 * @method OrderStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderStatus::class);
    }

    public function save(OrderStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Получить статус заказа по коду
     *
     * @param string $code
     * @return OrderStatus
     */
    public function getOrderStatusByCode(string $code): OrderStatus
    {
        $orderStatus = $this->findOneBy(['code' => $code]);

        if (null === $orderStatus) {
            throw new RepositoryException(
                message: 'Не найден статус заказа с кодом: ' . $code,
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'ORDER_STATUS_NOT_FOUND',
                logLevel: LogLevel::CRITICAL
            );
        }

        return $orderStatus;
    }
}
