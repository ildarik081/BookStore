<?php

namespace App\Repository;

use App\Component\Exception\RepositoryException;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Получить товар по идентификатору
     *
     * @param integer $id
     * @return Product
     * @throws RepositoryException
     */
    public function getProductById(int $id): Product
    {
        $product = $this->find($id);
        
        if (null === $product) {
            throw new RepositoryException(
                message: 'Товара с идентификатором ' . $id . ' у нас нет',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'PRODUCT_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        return $product;
    }
}
