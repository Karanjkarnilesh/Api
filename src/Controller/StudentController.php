<?php

namespace App\Controller;

use App\Controller\BaseController;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class StudentController extends BaseController
{
    protected $doctrine;
    protected $studentRepository;
    protected $serializer;
    public function __construct(ManagerRegistry $doctrine, StudentRepository $studentRepository, SerializerInterface $serializer)
    {
        $this->studentRepository = $studentRepository;
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;
    }
    /**
     * @Route("/task", name="task")
     */
    public function index(): Response
    {

        return $this->render('task/index.html.twig');
    }

    /**
     * @Route("/list", name="tasklist")
     */
    function list() {
        $student = $this->studentRepository->findAll();

        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);

    }
    /**
     * @Route("/update/{id}", name="taskupdate")
     */
    public function update(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
      
        $username = $request->request->get('_username');
        $last = $request->request->get('_lastname');
        $email = $request->request->get('_email');
        $class = $request->request->get('_studentclass');

        if ($student instanceof Student) {
            $student->setStudentId(007);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $student->setStudentClass($class);

            $entityManager->persist($student);
            $entityManager->flush();
            $student = $this->studentRepository->find(['id' => $student->getId()]);

            return $this->render('task/list.html.twig', [
                'students' => $student,
            ]);
        }
        return $this->render('task/edit.html.twig', [
            'students' => $student,
        ]);
    }
    /**
     * @Route("/delete/{id}", name="taskdelete")
     */
    public function delete(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(Student::class)->find($id);

        $entityManager->remove($student);
        $entityManager->flush();
        $student = $this->doctrine->getRepository(Student::class)->findAll();
        
        return $this->render('task/list.html.twig', [
            'students' => $student,
        ]);

    }

    /**
     * @Route("/search", name="tasksearch")
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
    public function add(Request $request): Response
    {

        $student = $this->doctrine->getRepository(Student::class)->findAll();
        $entityManager = $this->doctrine->getManager();

        if ($request->isMethod('POST')) {
            $username = $request->request->get('_username');
            $last = $request->request->get('_lastname');
            $email = $request->request->get('_email');
            $class = $request->request->get('_studentclass');

            $student = new Student();

            $student->setStudentId(2);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $student->setStudentClass($class);

            $entityManager->persist($student);
            $entityManager->flush();
            $student = $this->studentRepository->find(['id' => $student]);
            $student = $this->doctrine->getRepository(Student::class)->findAll();
            
            return $this->render('task/list.html.twig', [
                'students' => $student,
            ]);
        }
        return $this->render('task/add.html.twig', [
            'students' => $student,
        ]);

    }

    /**
     * @Route("/getteacher/{id}", name="taskGetTeacher")
     */
    public function getTeacher(Request $request, int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $student = new Student();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        $student_class = $student->getStudentClass();
        $teachers = $this->doctrine->getRepository(Teacher::class)->findBy(['class' => $student_class]);
        if ($teachers) {
            $student = $this->doctrine->getRepository(Student::class)->findAll();
            return $this->render('task/teacherlist.html.twig', [
                'teachers' => $teachers,
            ]);
        }
        return $this->render('task/teacherlist.html.twig', [
            'teacherError' => "Teacher is Not Present",
        ]);
    }

}
