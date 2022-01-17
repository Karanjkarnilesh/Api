<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Teacher;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $student_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $student_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $student_last;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $student_email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $student_class;

    //  /**
    //  * One Student has Many teachers.
    //  * @ORM\OneToMany(targetEntity="Teacher", mappedBy="student"))
    //  */
    // private $teachers;
       

    // public function __construct() {
    //     $this->teachers = new ArrayCollection();
    // }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentId(): ?string
    {
        return $this->student_id;
    }

    public function setStudentId(string $student_id): self
    {
        $this->student_id = $student_id;

        return $this;
    }

    public function getStudentName(): ?string
    {
        return $this->student_name;
    }

    public function setStudentName(string $student_name): self
    {
        $this->student_name = $student_name;

        return $this;
    }

    public function getStudentLast(): ?string
    {
        return $this->student_last;
    }

    public function setStudentLast(string $student_last): self
    {
        $this->student_last = $student_last;

        return $this;
    }

    public function getStudentEmail(): ?string
    {
        return $this->student_email;
    }

    public function setStudentEmail(string $student_email): self
    {
        $this->student_email = $student_email;

        return $this;
    }
    public function getStudentClass(): ?string
    {
        return $this->student_class;
    }

    public function setStudentClass(string $student_class): self
    {
        $this->student_class= $student_class;

        return $this;
    }
    // public function getTeacher()
    // {
    //     return $this->teachers;
    // }

    // public function setTeacher(ArrayCollection $events): self
    // {
    //     $this->teachers= $teachers;

    //     return $this;
    // }
}
