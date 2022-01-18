<?php

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Teacher;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class StudentController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine, StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->doctrine = $doctrine;
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

    function list(SerializerInterface $serializer) {
        $student = $this->studentRepository->findAll();
        $student = $serializer->serialize($student, 'json');
        $response = new Response($student);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return new JsonResponse(['students' => $student, 'status' => 'Student List'], Response::HTTP_OK);
    }
    /**
     * @Route("/update/{id}", name="taskupdate",methods={"PUT"})
     */
    public function update(int $id, Request $request, SerializerInterface $serializer)
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
            $student = $serializer->serialize($student, 'json');
            $response = new Response($student);

            $response->headers->set('Content-Type', 'application/json');
            return $response;
            // return new JsonResponse(['students' => $student, 'status' => 'Student update'], Response::HTTP_OK);

        }

        return new JsonResponse(['status' => 'Pass value for Student '], Response::HTTP_OK);
    }
    /**
     * @Route("/delete/{id}", name="taskdelete",methods={"DELETE"})
     */
    public function delete(int $id, SerializerInterface $serializer)
    {
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        $entityManager->remove($student);
        $entityManager->flush();
        $student = $serializer->serialize($student, 'json');
        $response = new Response($student);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return new JsonResponse(['status' => 'Student Deleted'], Response::HTTP_OK);
    }

    /**
     * @Route("/search", name="tasksearch",methods={"GET"})
     */
    public function search(Request $request,SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);
        $search = $data["_search"];
        $student = $this->studentRepository->search($search);
        $student = $serializer->serialize($student, 'json');
        $response = new Response($student);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return new JsonResponse(['students' => $student, 'status' => 'Students '], Response::HTTP_OK);
    }

    /**
     * @Route("/add", name="taskadd",methods={"POST|GET"})
     */
    public function add(Request $request,SerializerInterface $serializer): Response
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
        $student = $serializer->serialize($student, 'json');
        $response = new Response($student);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return new JsonResponse( $student, Response::HTTP_OK);

    }

    /**
     * @Route("/getteacher/{id}", name="taskGetTeacher",methods={"GET"})
     */
    public function getTeacher(Request $request, int $id,SerializerInterface $serializer)
    {
        $entityManager = $this->doctrine->getManager();

        $student = new Student();
        // $teacher = new Teacher();
        $student = $this->doctrine->getRepository(Student::class)->find($id);
        $student_class = $student->getStudentClass();
        $teachers = $this->doctrine->getRepository(Teacher::class)->findBy(['class' => $student_class]);
        $teacher = $serializer->serialize($teachers, 'json');
        $response = new Response($teacher);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return new JsonResponse(['teachers' => $teachers, 'status' => "Teacher For Class {$student_class}"], Response::HTTP_OK);
    }

}
