<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Repository\StudentRepository;
use App\Repository\TeacherRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine, StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    /**
     * @Route("/task", name="task")
     */
    public function index(): Response
    {

        return $this->render('task/index.html.twig');
    }

    /**
     * @Route("/list", name="tasklist",methods={"GET"})
     */

    function list() {
        $student = $this->studentRepository->findAll();
        // return $this->render('task/list.html.twig', [
        //     'students' => $student,
        // ]);
        return new JsonResponse(['result' => 'ok', 'ret' => ['students' => $student]]);
    }
    /**
     * @Route("/update/{id}", name="taskupdate",methods={"PUT"})
     */
    public function update(ManagerRegistry $doctrine, int $id, Request $request)
    {
        $entityManager = $doctrine->getManager();
        $student = $doctrine->getRepository(Student::class)->find($id);
        $username = $request->request->get('_username');
        $last = $request->request->get('_lastname');
        $email = $request->request->get('_email');
        $class = $request->request->get('_studentclass');

        if (($student != '') && ($last != '') && ($email != '')) {
            $student->setStudentId(007);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $student->setStudentClass($class);

            $entityManager->persist($student);

            $entityManager->flush();
            $student = $this->studentRepository->findAll();

            return $this->render('task/list.html.twig', [
                'students' => $student,
            ]);
        }

        return $this->render('task/edit.html.twig', [
            'students' => $student,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="taskdelete",methods={"DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, int $id)
    {
        $entityManager = $doctrine->getManager();
        $student = $doctrine->getRepository(Student::class)->find($id);
        // dd($student);
        $entityManager->remove($student);
        $entityManager->flush();
        $student = $this->studentRepository->findAll();
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);
    }

    /**
     * @Route("/search", name="tasksearch")
     */
    public function search(ManagerRegistry $doctrine, StudentRepository $studentRepository, Request $request)
    {
        // $entityManager = $doctrine->getManager();
        $search = $request->request->get('_search');
        // $repo = $entityManager->getRepository(Student::class);

        $student = $this->studentRepository->search($search);
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);
    }

    /**
     * @Route("/add", name="taskadd",methods={"POST"})
     */
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $entityManager = $doctrine->getManager();
            $username = $request->request->get('_username');
            $last = $request->request->get('_lastname');
            $email = $request->request->get('_email');
            $class = $request->request->get('_studentclass');
            $student = new Student();
            // $teacher=new Teacher();

            $student->setStudentId(2);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $student->setStudentClass($class);
            // $teacher->setStudent($student);
            $entityManager->persist($student);
            // $entityManager->persist($teacher);
            $entityManager->flush();
            $student = $this->studentRepository->findAll();
            return $this->render('task/list.html.twig', [
                'students' => $student,
            ]);
        }
        return $this->render('task/add.html.twig');
    }

    /**
     * @Route("/getteacher/{id}", name="taskGetTeacher")
     */
    public function getTeacher(ManagerRegistry $doctrine, StudentRepository $studentRepository, Request $request, int $id, TeacherRepository $teacherRepository)
    {
        $entityManager = $doctrine->getManager();

        $student = new Student();
        // $teacher = new Teacher();
        $student = $doctrine->getRepository(Student::class)->find($id);
        $student_class = $student->getStudentClass();
        $teachers = $doctrine->getRepository(Teacher::class)->findBy(['class' => $student_class]);
            return $this->render('task/teacherlist.html.twig', [
                'teachers' => $teachers,
            ]);
    }

}
