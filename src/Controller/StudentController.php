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
     * @Route("/list", name="tasklist",methods={"GET"})
     */

    function list() {
        $student = $this->studentRepository->findAll();

        $response = $this->responsiveJson($student);
        return $response;
        // return $this->render('task/list.html.twig',[
        //     'students'=>$student
        // ]);

    }
    /**
     * @Route("/update/{id}", name="taskupdate",methods={"PUT"})
     */

    public function update(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(Student::class)->find($id);

        $username = $data['_username'];
        $last = $data['_lastname'];
        $email = $data['_email'];
        $class = $data['_studentclass'];

        if (($student != '') && ($last != '') && ($email != '')) {
            $student->setStudentId(007);
            $student->setStudentName($username);
            $student->setStudentLast($last);
            $student->setStudentEmail($email);
            $student->setStudentClass($class);

            $entityManager->persist($student);

            $entityManager->flush();
            $student = $this->studentRepository->find(['id' => $student->getId()]);
            $response = $this->responsiveJson($student);
            return $response;
            // return $this->render('task/list.html.twig', [
            //     'students' => $student,
            // ]);

        }
        // return $this->render('task/list.html.twig', [
        //     'students' => $student,
        // ]);
        // return new JsonResponse(['status' => 'Pass value for Student '], Response::HTTP_OK);
    }
    /**
     * @Route("/delete/{id}", name="taskdelete",methods={"DELETE"})
     */
    //
    public function delete(int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        $entityManager->remove($student);
        $entityManager->flush();
        $response = $this->responsiveJson($student);
        return $response;
        // return $this->render('task/list.html.twig',[
        //     'students'=>$student
        // ]);

    }

    /**
     * @Route("/search", name="tasksearch",methods={"GET"})
     */
    //
    public function search(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $search = $data["_search"];
        $student = $this->studentRepository->search($search);
        $response = $this->responsiveJson($student);
        return $response;
        // return $this->render('task/list.html.twig',[
        //     'students'=>$student
        // ]);
    }

    /**
     * @Route("/add", name="taskadd",methods={"POST|GET"})
     */
    public function add(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->doctrine->getManager();

        $username = $data['_username'];
        $last = $data['_lastname'];
        $email = $data['_email'];
        $class = $data['_studentclass'];

        $student = new Student();

        $student->setStudentId(2);
        $student->setStudentName($username);
        $student->setStudentLast($last);
        $student->setStudentEmail($email);
        $student->setStudentClass($class);
        $entityManager->persist($student);
        $entityManager->flush();
        $student = $this->studentRepository->find(['id' => $student->getId()]);
        $response = $this->responsiveJson($student);
        return $response;
        // return $this->render('task/list.html.twig',[
        //     'students'=>$student
        // ]);

    }

    /**
     * @Route("/getteacher/{id}", name="taskGetTeacher",methods={"GET"})
     */
    //
    public function getTeacher(Request $request, int $id)
    {
        $entityManager = $this->doctrine->getManager();
        $student = new Student();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        $student_class = $student->getStudentClass();
        $teachers = $this->doctrine->getRepository(Teacher::class)->findBy(['class' => $student_class]);
        $response = $this->responsiveJson($teachers);
        return $response;
        // return $this->render('task/teacherlist.html.twig',[
        //     'teachers'=>$teachers
        // ]);
    }

}
