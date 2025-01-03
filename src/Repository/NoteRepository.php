<?php

namespace App\Repository;

use App\Entity\Note;
use App\Layer\Domain\Note\Dto\ListNoteDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * @param ListNoteDto $listNoteDto
     * @return array|Note[]
     */
    public function listByParams(ListNoteDto $listNoteDto): array
    {
        $result = $this->createQueryBuilder('n')->where(['n.user_id = :userId'])
            ->setParameter('userId', $listNoteDto->getUserId());

        if ($listNoteDto->getFilterByCategoryId()) {
            $result->andWhere('n.category_id = :categoryId')
                ->setParameter('categoryId', $listNoteDto->getFilterByCategoryId());
        }

        return $result->getQuery()->getResult();
    }

    //    /**
    //     * @return Note[] Returns an array of Note objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Note
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
