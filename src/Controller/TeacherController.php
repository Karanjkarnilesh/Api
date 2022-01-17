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
<<<<<<< HEAD
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
=======

    public function __construct(TeacherService $teacherService, TeacherRepository $teacherRepository)
    {
        $this->teacherService = $teacherService;

        $this->teacherRepository = $teacherRepository;
    }
/**
 * @Route("/teacher", name="teacher")
 */
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
    public function index()
    {

        return $this->render('teacher/index.html.twig');
    }

    /**
     * @Route("/teacher/create", name="teachercreate")
     */
<<<<<<< HEAD
    public function create(Request $request)
=======
    public function create(Request $request, ManagerRegistry $doctrine, TeacherService $teacherService)
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
    {
        if ($request->isMethod('POST')) {
            $teacherObj = array();
            $teacherObj['Name'] = $request->request->get('_name');
            $teacherObj['Salary'] = $request->request->get('_salary');
            $teacherObj['Designation'] = $request->request->get('_designation');
<<<<<<< HEAD
            $teacherObj['Class'] = $request->request->get('_teacherclass');
            $teacherObj['CreateAt'] = new DateTime();
            $teacherObj['UpdateAt'] = new DateTime();
            $teacherObj = $this->teacherService->add($teacherObj,$this->doctrine);
           
             $teacherObj=$this->teacherService->getAll($this->teacherRepository);
           
=======
            $teacherObj['Class'] = $request->request->get('_teacherclass');  
            $teacherObj['CreateAt'] = new DateTime();
            $teacherObj['UpdateAt'] = new DateTime() ;
            $teacherObj = $teacherService->add($teacherObj, $doctrine, $this->teacherRepository);
            $this->addFlash('success', "Teacher Added Successfully");
            $teacherObj = $this->teacherRepository->findAll();
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
            return $this->render('teacher/list.html.twig', [
                'teachers' => $teacherObj,
            ]);
        }
        return $this->render('teacher/add.html.twig');
    }

    /**
     * @Route("/teacher/update/{id}", name="teacherupdate")
     */
<<<<<<< HEAD
    public function update(Request $request, int $id, )
    {

        $data = array();
        $teacher = $this->doctrine->getRepository(Teacher::class)->find($id);
=======
    public function update(Request $request, int $id, ManagerRegistry $doctrine, TeacherService $teacherService)
    {

        $data = array();
        $teacher = $doctrine->getRepository(Teacher::class)->find($id);
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
        $data['Name'] = $request->request->get('_name');
        $data['Salary'] = $request->request->get('_salary');
        $data['Designation'] = $request->request->get('_designation');
        $data['Class'] = $request->request->get('_teacherclass');
<<<<<<< HEAD
        $data['UpdateAt'] = new DateTime();
        if (($data['Name'] != '') && ($data['Salary'] != '') && ($data['Class'] != '')) {
            $teacherObj = $this->teacherService->edit($data, $id);
            if ($teacherObj) {
                 $teacher=$this->teacherService->getAll($this->teacherRepository);
=======
        $data['UpdateAt'] = new DateTime() ;
        if (($data['Name'] != '') && ($data['Salary'] != '') && ($data['Class'] != '')) {
            $teacherObj = $teacherService->edit($data, $doctrine, $this->teacherRepository, $id);
            if ($teacherObj) {
                $teacher = $this->teacherRepository->findAll();

>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
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
<<<<<<< HEAD
    public function delete(int $id)
    {
        
        $entityManager = $this->doctrine->getManager();
        $student = $this->doctrine->getRepository(teacher::class)->find($id);
        $result = $this->teacherService->delete($student);
        if (!empty($result)) {
            $this->addFlash('success', "Teacher Delete Successfully");
            $teacher=$this->teacherService->getAll($this->teacherRepository);
=======
    public function delete(int $id, ManagerRegistry $doctrine)
    {

        $entityManager = $doctrine->getManager();
        $student = $doctrine->getRepository(teacher::class)->find($id);
        $result = $this->teacherService->delete($student, $doctrine, $this->teacherRepository);
        if (!empty($result)) {
            $this->addFlash('success', "Teacher Delete Successfully");
            $teacher = $this->teacherRepository->findAll();
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
            return $this->render('teacher/list.html.twig', [
                'teachers' => $teacher,
            ]);
        }
    }

    /**
     * @Route("/teacher/list", name="teacherlist")
     */
<<<<<<< HEAD
    public function teacherList()
    {

         $teacher=$this->teacherService->getAll($this->teacherRepository);
=======
    public function teacherList(TeacherRepository $teacherRepository)
    {
        $teacher = $this->teacherService->getAll($teacherRepository);
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
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
<<<<<<< HEAD
    public function search( Request $request)
=======
    public function search(TeacherRepository $teacherRepository, Request $request)
>>>>>>> 0cd5fccd568bc982da98d7fd43fd495bb55cbd67
    {
        $search = $request->request->get('_search');
        $teacher = $this->teacherRepository->search($search);
        return $this->render('teacher/list.html.twig', [
            'teachers' => $teacher,
        ]);
    }

}
