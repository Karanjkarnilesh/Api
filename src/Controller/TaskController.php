<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(ManagerRegistry $doctrine, Request $request, StudentRepository $studentRepository): Response
    {
        if ($request->isMethod('POST')) {
            $entityManager = $doctrine->getManager();
            $username = $request->request->get('_username');
            $last = $request->request->get('_lastname');
            $email = $request->request->get('_email');
            $student = new Student();
            $student->setStudentId(2);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $entityManager->persist($student);
            $entityManager->flush();
            $student = $studentRepository->findAll();
            return $this->render('task/list.html.twig',[
                'students'=>$student
            ]);
        }
        return $this->render('task/add.html.twig');
    }

     /**
     * @Route("/list", name="tasklist")
     */

    public function list(StudentRepository $studentRepository)
    {
        $student = $studentRepository->findAll();
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);
    }
    /**
     * @Route("/update/{id}", name="taskupdate")
     */
    public function update(ManagerRegistry $doctrine, int $id, Request $request, StudentRepository $studentRepository)
    {
        $entityManager = $doctrine->getManager();
        $student = $doctrine->getRepository(Student::class)->find($id);
        $username = $request->request->get('_username');
        $last = $request->request->get('_lastname');
        $email = $request->request->get('_email');

        if (($student != '') && ($last != '') && ($email != '')) {
            $student->setStudentId(007);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $entityManager->persist($student);
            $entityManager->flush();
            $student = $studentRepository->findAll();
            return $this->render('task/list.html.twig',[
                'students'=>$student
            ]);
        }
      
        return $this->render('task/edit.html.twig', [
            'students' => $student,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="taskdelete")
     */
    public function delete(ManagerRegistry $doctrine, int $id, StudentRepository $studentRepository)
    {
        $entityManager = $doctrine->getManager();
        $student = $doctrine->getRepository(Student::class)->find($id);
        $entityManager->remove($student);
        $entityManager->flush();
        $student = $studentRepository->findAll();
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);
    }
}
