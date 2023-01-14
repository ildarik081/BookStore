<?php

namespace App\Repository;

use App\Component\Exception\RepositoryException;
use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Получить корзину по идентификатору сессии
     *
     * @param string $sessionId
     * @param bool $checkEmpty
     * @return Cart|null
     * @throws RepositoryException
     */
    public function getCartBySessionId(string $sessionId, bool $checkEmpty = false): ?Cart
    {
        $cart = $this->findOneBy(['sessionId' => $sessionId]);

        if (null === $cart && $checkEmpty) {
            throw new RepositoryException(
                message: 'У вас пустая корзина',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'CART_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        return $cart;
    }
}
