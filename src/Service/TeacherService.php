<?php
namespace App\Service;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;

class TeacherService
{

    private $teacherRepository;
    private $doctrine;
    public function __construct(ManagerRegistry $doctrine,TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
        $this->doctrine = $doctrine;
    }
   
    public function add($teacherobj): array
    {
        if (!empty($teacherobj)) {
            $entityManager = $this->doctrine->getManager();
            $teacher = new Teacher();
            foreach ($teacherobj as $key => $val) {
                $func = "set$key";
                $teacher->$func($val);
            }

            $entityManager->persist($teacher);

            $entityManager->flush();

            $teacher = $this->teacherRepository->findAll();

            $teacher = $this->teacherRepository->findAll();


            return $teacher;
        }

    }


    public function edit($teacherobj, int $id)
    {
        if ($id) {
            $teacher = $this->doctrine->getRepository(Teacher::class)->find($id);
            $entityManager = $this->doctrine->getManager();
            // $teacher = new Teacher();

            foreach ($teacherobj as $key => $val) {
                $func = "set$key";

                $teacher->$func($val);
            }

            $entityManager->persist($teacher);
            $entityManager->flush();

            return $teacher;
        }

    }

 
    public function delete($teacherobj)
    {
        if (!empty($teacherobj)) {
            $entityManager = $this->doctrine->getManager();

            $entityManager->remove($teacherobj);
            $entityManager->flush();

            return "Done";
        }
    }

    public function getAll()
    {
        return $this->teacherRepository->findAll();
    }

}
