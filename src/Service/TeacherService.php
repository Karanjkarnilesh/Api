<?php
namespace App\Service;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class TeacherService
{
    public function __construct(TeacherRepository $teacherRepository, ManagerRegistry $doctrine, )
    {
        $this->teacherRepository = $teacherRepository;
        $this->doctrine = $doctrine;
    }

    public function add($teacherargs)
    {
        if (!empty($teacherargs)) {
            $entityManager = $this->doctrine->getManager();
            $teacher = new Teacher();
            $teacher->setName($teacherargs['_name']);
            $teacher->setSalary($teacherargs['_salary']);
            // $teacher->setClass($teacherargs['_class']);
            $teacher->setDesignation($teacherargs['_designation']);
            $teacher->setCreateAt(new DateTime());
            $teacher->setUpdateAt(new DateTime());
            $price = $teacherargs['_salary'];
            if (strtolower($teacherargs['_designation']) == "developer") {
                $price = $price = $price + (50 / 100) * $price;
                $teacher->setSalary($price);
            } else {
                $teacher->setSalary($teacherargs['_salary']);
            }
            $teacher->setClass($teacherargs['_studentclass']);

            $entityManager->persist($teacher);
            $entityManager->flush();

            $teacher = $this->getAll();
            return $teacher;
        }
        return;
    }

    public function edit($data, int $id)
    {
        if ($id) {
            $teacher = $this->doctrine->getRepository(Teacher::class)->find($id);
            $entityManager = $this->doctrine->getManager();

            $teacher->setName($data['_name']);
            $teacher->setSalary($data['_salary']);
            $teacher->setDesignation($data['_designation']);
            $teacher->setClass($data['_studentclass']);
            $teacher->setUpdateAt(new DateTime());
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

    public function getAll($args = array())
    {
        if (!empty($args)) {
            return $this->doctrine->getRepository(Teacher::class)->find($args);
        }
        return $this->doctrine->getRepository(Teacher::class)->findAll();
    }

    public function searchdata($search)
    {
       return  $this->teacherRepository->search($search);
    }

    public function incerement($designation)
    {
        $entityManager = $this->doctrine->getManager();

        $teachers = $this->doctrine->getRepository(Teacher::class)->findAll();
        $count = 0;
        foreach ($teachers as $key => $teacher) {
            if ($teacher->getDesignation() == 'developer') {
                $price = $teacher->getSalary();

                $price = $price = floatval($price + ($designation / 100) * $price);

                $teacher->setSalary($price);

                $entityManager->persist($teacher);
                $entityManager->flush();
                $count++;
            }

        }
        if ($count >= 1) {
            return "changes Done";
        }
        return;
    }

}
