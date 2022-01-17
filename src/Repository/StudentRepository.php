<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
    return $this->createQueryBuilder('s')
    ->andWhere('s.exampleField = :val')
    ->setParameter('val', $value)
    ->orderBy('s.id', 'ASC')
    ->setMaxResults(10)
    ->getQuery()
    ->getResult()
    ;
    }
     */

    /*
    public function findOneBySomeField($value): ?Student
    {
    return $this->createQueryBuilder('s')
    ->andWhere('s.exampleField = :val')
    ->setParameter('val', $value)
    ->getQuery()
    ->getOneOrNullResult()
    ;
    }
     */

    /**
     * @return Student[] Returns an array of Student objects
     */
    public function search(string $value): array
    {
        $criteria = Criteria::create()
            ->where(new Comparison('student_name', Comparison::CONTAINS, $value))
            ->orWhere(new Comparison('student_email', Comparison::CONTAINS, $value))
            ->orWhere(new Comparison('student_last', Comparison::CONTAINS, $value));
        return $this->matching($criteria)->toArray();
    }
    /**
     * @return Student[]
     */
    public function joinStudentAndTeacher(int $student_id)
    {

        return $this->createQueryBuilder("s")
            ->leftJoin('App\Entity\Teacher', "t", Join::WITH, "t.class = :student_class")
            ->setParameter("student_class", $student_id)->addSelect('t')
            ->getQuery()->getResult();

    //     $query = $this->createQueryBuilder('a')
    //     ->select(Teacher::class, 'a')
    //    ->where('a.class = :class')                
    //     ->setParameter('class', $student_id)
    //     ->getQuery()
    //     ->getResult();
    }


}
