<?php

namespace App\Controller;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;
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
  
    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
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
    public function create(Request $request, SerializerInterface $serializer):Response
    {
        $data = json_decode($request->getContent(), true);
      
            $teacherObj = array();
        
            $teacherObj['Name']= $data['_name'];
            $teacherObj['Salary'] = $data['_salary'];
            $teacherObj['Designation']= $data['_designation'];
            $teacherObj['Class']= $data['_studentclass'];
            $teacherObj['CreateAt'] = new DateTime();
            $teacherObj['UpdateAt'] = new DateTime() ;

            $teacherObj = $this->teacherService->add($teacherObj);
         

        $student = $serializer->serialize($teacherObj, 'json');
        $response = new Response($student);

        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    /**
     * @Route("/teacher/update/{id}", name="teacherupdate",methods={"PUT"})
     */
    public function update(Request $request, int $id,SerializerInterface $serializer)
    {
        $data = json_decode($request->getContent(), true);

        $args=[
            'id'=>$id
        ];
        $teacher = $this->teacherService->getAll($args);

        $teacherObj['Name']= $data['_name'];
        $teacherObj['Salary'] = $data['_salary'];
        $teacherObj['Designation']= $data['_designation'];
        $teacherObj['Class']= $data['_studentclass'];


        $teacherObj['UpdateAt'] = new DateTime();
        if (($teacherObj['Name'] != '') && ($teacherObj['Salary'] != '') && ($teacherObj['Class'] != '')) {
            $teacherObj = $this->teacherService->edit($teacherObj, $id);
            if ($teacherObj) {
                 $teacher=$this->teacherService->getAll($args);
             
                $teacher = $serializer->serialize($teacher, 'json');
                $response = new Response($teacher);
        
                $response->headers->set('Content-Type', 'application/json');
                return $response;
                    

            }

        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
        ]);
    }
    /**
     * @Route("/teacher/delete/{id}", name="teacherdelete",methods={"DELETE"})
     */
    function delete(int $id,SerializerInterface $serializer) 
    {
        $args=[
            'id'=>$id
        ];
        $student =$this->teacherService->getAll($args);
        $result = $this->teacherService->delete($student);
        if ($result=="Done") {
            
            return new JsonResponse(['status' => 'Teacher Delete'], Response::HTTP_OK);
     
        }
        return new JsonResponse(['status' => 'teacher Not Avaliable'], Response::HTTP_OK);
    }
        
    /**
     * @Route("/teacher/list", name="teacherlist")
     */
    function teacherList(SerializerInterface $serializer)
    {
        $teacher = $this->teacherService->getAll();

        if (!empty($teacher)) {
           
            $teacher = $serializer->serialize($teacher, 'json');
            $response = new Response($teacher);
    
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        return new JsonResponse(['status'=>'Teacher Not Avaliable']);
    }

    /**
     * @Route("/teacher/search", name="teachersearch")
     */
    function search(Request $request,SerializerInterface $serializer)
    {
        $search = $request->request->get('_search');
        $teacher = $this->teacherService->searchdata($search);
        $teacher = $serializer->serialize($teacher, 'json');
        $response = new Response($teacher);

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
