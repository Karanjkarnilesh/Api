<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

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
}
