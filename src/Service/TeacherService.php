<?php
namespace App\Service;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;

class TeacherService
{
<<<<<<< HEAD
    private $teacherRepository;
    private $doctrine;
    // public function __construct(ManagerRegistry $doctrine)
    // {
        // $this->teacherRepository = $teacherRepository;
        // $this->doctrine = $doctrine;
    // }
    public function add($teacherobj): array
    {
        // $this->doctrine=new ManagerRegistry();

        if (!empty($teacherobj)) {
            $entityManager = $this->doctrine->getManager();
=======
    public $id = '';
    public $name = '';
    public $salary = 0.0;
    public $designation = '';

    // public function __construct(TeacherRepository $teacherRepository)
    // {
    //     $this->teacherRepository = $teacherRepository;
    // }
    public function add($teacherobj, ManagerRegistry $doctrine, TeacherRepository $teacherRepository): array
    {
        if (!empty($teacherobj)) {
            $entityManager = $doctrine->getManager();
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
            $teacher = new Teacher();

            foreach ($teacherobj as $key => $val) {
                $func = "set$key";
                $teacher->$func($val);
            }

            $entityManager->persist($teacher);

            $entityManager->flush();
<<<<<<< HEAD
            $teacher = $this->teacherRepository->findAll();
=======
            $teacher = $teacherRepository->findAll();
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67

            return $teacher;
        }

    }

<<<<<<< HEAD
    public function edit($teacherobj,int $id)
    {
        if ($id) {
            $teacher = $this->doctrine->getRepository(Teacher::class)->find($id);
            $entityManager = $this->doctrine->getManager();
=======
    public function edit($teacherobj, ManagerRegistry $doctrine, $teacherRepository, int $id)
    {
        if ($id) {
            $teacher = $doctrine->getRepository(Teacher::class)->find($id);
            $entityManager = $doctrine->getManager();
            // $teacher = new Teacher();
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
            foreach ($teacherobj as $key => $val) {
                $func = "set$key";

                $teacher->$func($val);
            }

            $entityManager->persist($teacher);
            $entityManager->flush();

            return $teacher;
        }

    }

<<<<<<< HEAD
    public function delete($teacherobj)
    {
        if (!empty($teacherobj)) {
            $entityManager = $this->doctrine->getManager();
=======
    public function delete($teacherobj, $doctrine, $teacherRepository)
    {
        if (!empty($teacherobj)) {
            $entityManager = $doctrine->getManager();
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
            $entityManager->remove($teacherobj);
            $entityManager->flush();

            return "Done";
        }
    }

    public function getAll(TeacherRepository $teacherRepository)
    {
<<<<<<< HEAD
=======

>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
        return $teacherRepository->findAll();
    }

}
