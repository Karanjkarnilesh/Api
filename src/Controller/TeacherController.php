<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    private $teacherService;
    private $teacherRepository;
    private $doctrine;
    public function __construct(TeacherRepository $teacherRepository, ManagerRegistry $doctrine,TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
        $this->doctrine = $doctrine;

        $this->teacherRepository = $teacherRepository;
    }
    /**
     * @Route("/teacher", name="teacher")
     */
    public function index()
    {

        return $this->render('teacher/index.html.twig');
    }

    /**
     * @Route("/teacher/create", name="teachercreate")
     */
    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {
            $teacherObj = array();
            $teacherObj['Name'] = $request->request->get('_name');
            $teacherObj['Salary'] = $request->request->get('_salary');
            $teacherObj['Designation'] = $request->request->get('_designation');
            $teacherObj['Class'] = $request->request->get('_teacherclass');
            $teacherObj['CreateAt'] = new DateTime();
            $teacherObj['UpdateAt'] = new DateTime();
            $teacherObj = $this->teacherService->add($teacherObj,$this->doctrine);
           
             $teacherObj=$this->teacherService->getAll($this->teacherRepository);
           
            return $this->render('teacher/list.html.twig', [
                'teachers' => $teacherObj,
            ]);
        }
        return $this->render('teacher/add.html.twig');
    }

    /**
     * @Route("/teacher/update/{id}", name="teacherupdate")
     */
    public function update(Request $request, int $id, )
    {

        $data = array();
        $teacher = $this->doctrine->getRepository(Teacher::class)->find($id);
        $data['Name'] = $request->request->get('_name');
        $data['Salary'] = $request->request->get('_salary');
        $data['Designation'] = $request->request->get('_designation');
        $data['Class'] = $request->request->get('_teacherclass');
        $data['UpdateAt'] = new DateTime();
        if (($data['Name'] != '') && ($data['Salary'] != '') && ($data['Class'] != '')) {
            $teacherObj = $this->teacherService->edit($data, $id);
            if ($teacherObj) {
                 $teacher=$this->teacherService->getAll($this->teacherRepository);
                return $this->render('teacher/list.html.twig', [
                    'teachers' => $teacher,
                ]);

            }

        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * @Route("/teacher/delete/{id}", name="teacherdelete")
     */
    public function delete(int $id)
    {
        
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(teacher::class)->find($id);
        $result = $this->teacherService->delete($student);
        if (!empty($result)) {
            $this->addFlash('success', "Teacher Delete Successfully");
            $teacher=$this->teacherService->getAll($this->teacherRepository);
            return $this->render('teacher/list.html.twig', [
                'teachers' => $teacher,
            ]);
        }
    }

    /**
     * @Route("/teacher/list", name="teacherlist")
     */
    public function teacherList()
    {

         $teacher=$this->teacherService->getAll($this->teacherRepository);
        if (!empty($teacher)) {
            return $this->render('teacher/list.html.twig', [
                'teachers' => $teacher,
            ]);
        }
        return;
    }

    /**
     * @Route("/teacher/search", name="teachersearch")
     */
    public function search( Request $request)
    {
        $search = $request->request->get('_search');
        $teacher = $this->teacherRepository->search($search);
        return $this->render('teacher/list.html.twig', [
            'teachers' => $teacher,
        ]);
    }

}
