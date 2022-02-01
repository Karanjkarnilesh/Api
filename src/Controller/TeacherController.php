<?php

namespace App\Controller;

use App\Service\TeacherService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TeacherController extends AbstractController
{

    private $teacherService;
    protected $serializer;
    public function __construct(TeacherService $teacherService, SerializerInterface $serializer)
    {
        $this->teacherService = $teacherService;
        $this->serializer = $serializer;
    }
    /**
     * @Route("/teacher", name="teacher")
     */

    public function index()
    {

        return $this->render('teacher/index.html.twig');
    }

    /**
     * @Route("/teacher/create", name="teachercreate",methods={"POST|GET"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $teacherObj = $this->teacherService->add($data);

        if ($teacherObj) {
            $student = $this->serializer->serialize($teacherObj, 'json');
            $response = new Response($student);

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return new JsonResponse(['status' => 'Please fill all Field']);
    }

    /**
     * @Route("/teacher/update/{id}", name="teacherupdate",methods={"PUT"})
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);

        $args = [
            'id' => $id,
        ];
        $teacher = $this->teacherService->getAll($args);

        $data['UpdateAt'] = new DateTime();
        if (($data['_name'] != '') && ($data['_salary'] != '') && ($data['_designation'] != '')) {
            $teacherObj = $this->teacherService->edit($data, $id);
            if ($teacherObj) {
                $teacher = $this->teacherService->getAll($args);

                $teacher = $this->serializer->serialize($teacher, 'json');
                $response = new Response($teacher);

                $response->headers->set('Content-Type', 'application/json');
                return $response;

            }

        }
        return new JsonResponse(['status' => 'teacher Data Update Successfully '], Response::HTTP_OK);
        // return $this->render('teacher/edit.html.twig', [
        //     'teacher' => $teacher,
        // ]);
    }
    /**
     * @Route("/teacher/delete/{id}", name="teacherdelete",methods={"DELETE"})
     */
    public function delete(int $id)
    {
        $args = [
            'id' => $id,
        ];
        $student = $this->teacherService->getAll($args);
        $result = $this->teacherService->delete($student);
        if ($result == "Done") {

            return new JsonResponse(['status' => 'Teacher Delete'], Response::HTTP_OK);

        }
        return new JsonResponse(['status' => 'teacher Not Avaliable'], Response::HTTP_OK);
    }

    /**
     * @Route("/teacher/list", name="teacherlist")
     */
    public function teacherList()
    {
        $teacher = $this->teacherService->getAll();

        if (!empty($teacher)) {
            $student = $this->serializer->serialize($teacher, 'json');
            $response = new Response($student);

            $response->headers->set('Content-Type', 'application/json');
            return $response;
            // return $this->render('teacher/list.html.twig',[
            //     'students'=>$teacher
            // ]);
        }
        return new JsonResponse(['status' => 'Teacher Not Avaliable']);
    }

    /**
     * @Route("/teacher/search", name="teachersearch")
     */
    public function search(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // $search = $request->request->get('_search');
        $search = $data['_search'];
        
        $teacher = $this->teacherService->searchdata($search);
    
        $student = $this->serializer->serialize($teacher, 'json');
        $response = new Response($student);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
        // return $this->render('teacher/list.html.twig',[
        //         'students'=>$teacher
        //     ]);
    }

    /**
     * @Route("/teacher/incerement", name="TeacherInc",methods={"GET"})
     */
    public function teacherInc(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $teacherIncerement = $this->teacherService->incerement($data['_increment']);
        if ($teacherIncerement) {

            $response = new JsonResponse(['Message' => "Teacher Salary changes"]);

            return $response;
        }
        $response = new JsonResponse(['Message' => "please pass a Increment in Percentage"]);
        return $response;

    }
}
