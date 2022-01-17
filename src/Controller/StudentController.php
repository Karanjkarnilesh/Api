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
    protected $teacherRepository;
    protected $studentRepository;
    protected $doctrine;
    public function __construct(ManagerRegistry $doctrine, StudentRepository $studentRepository, TeacherRepository $teacherRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->doctrine = $doctrine;
        $this->teacherRepository = $teacherRepository;
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

    function list(): JsonResponse {
        $student = $this->studentRepository->findAll();
        // return $this->render('task/list.html.twig', [
        //     'students' => $student,
        // ]);
        // $student=json_encode($student);
        return new JsonResponse($student);
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
        return new JsonResponse($student, Response::HTTP_OK);
    }
    /**
     * @Route("/delete/{id}", name="taskdelete",methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        // dd($student);
        $entityManager->remove($student);
        $entityManager->flush();
        $student = $this->studentRepository->findAll();
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);
    }

    /**
     * @Route("/search", name="tasksearch",methods={"POST"} )
     */
    public function search(Request $request)
    {

        $search = $request->request->get('_search');
        $student = $this->studentRepository->search($search);
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);
    }

    /**
     * @Route("/add", name="taskadd")
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        dd($data);
        // dd($data['username']);
        if ($request->isMethod('POST')) {
            $entityManager = $this->doctrine->getManager();
            $username = $request->request->get('_username');
            $last = $request->request->get('_lastname');
            $email = $request->request->get('_email');
            $class = $request->request->get('_studentclass');
            $student = new Student();
            // $teacher=new Teacher();
            dump($username);
            dump($last);
            dump($email);
            dump($class);
// dd();
            $student->setStudentId("2");
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $student->setStudentClass($class);
            dd($student);
            $entityManager->persist($student);
            $entityManager->flush();
            // $student = $this->studentRepository->findAll();
            // return $this->render('task/list.html.twig', [
            //     'students' => $student,
            // ]);
            return new JsonResponse($student, Response::HTTP_OK);
        }
        // return new JsonResponse($student, Response::HTTP_OK);
        return $this->render('task/add.html.twig');
    }

    /**
     * @Route("/getteacher/{id}", name="taskGetTeacher")
     */
    public function getTeacher(Request $request, int $id)
    {
        $entityManager = $this->doctrine->getManager();

        $student = new Student();
        // $teacher = new Teacher();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        $student_class = $student->getStudentClass();
        $teachers = $this->doctrine->getRepository(Teacher::class)->findBy(['class' => $student_class]);
        return $this->render('task/teacherlist.html.twig', [
            'teachers' => $teachers,
        ]);
    }

}
