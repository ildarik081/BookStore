<?php

namespace App\Repository;

use App\Component\Exception\RepositoryException;
use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @extends ServiceEntityRepository<Image>
 *
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function save(Image $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Image $entity, bool $flush = false): void
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
     * @return Image
     * @throws RepositoryException
     */
    public function getImageById(int $id): Image
    {
        $image = $this->find($id);

        if (null === $image) {
            throw new RepositoryException(
                message: 'Изображения с идентификатором ' . $id . ' у нас нет',
                code: ResponseAlias::HTTP_BAD_REQUEST,
                responseCode: 'IMAGE_NOT_FOUND',
                logLevel: LogLevel::WARNING
            );
        }

        return $image;
    }

    /**
     * Получить массив изображений по их идентификаторам
     *
     * @param array $ids
     * @return Image[]
     */
    public function getImagesByIds(array $ids): array
    {
        return $this
            ->createQueryBuilder('i')
            ->select('i')
            ->where($this->createQueryBuilder('i')->expr()->in('i.id', ':ids'))
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}
