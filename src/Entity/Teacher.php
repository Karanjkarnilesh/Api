<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Teacher
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
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @Assert\Range(
     *      min = 1,
     *      max = 12,
     *      notInRangeMessage = "You must be between {{ min }}cm and {{ max }}cm tall to enter",
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $class;

    /**
     * @ORM\Column(type="datetime", length=255)
     * * @var string A "Y-m-d H:i:s" formatted value
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $update_at;

    // /**
    //  * Many features have one student. This is the owning side.
    //  * @ORM\ManyToOne(targetEntity="Student")
    //  */
    // private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function setCreateAt($create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getCreateAt()
    {
        return ($this->create_at);
    }

    public function setUpdateAt($update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getUpdateAt()
    {
        return ($this->update_at);
    }

    // public function getStudent(): ?string
    // {
    //     return $this->student;
    // }
    // public function setStudent(Student $student): self
    // {
    //     $this->student=$student;
    //     return $this;
    // }

    // /**
    //  * @ORM\PrePersist
    //  */
    // public function setCreatedAtValue()
    // {
    //     $this->createdAt = new \DateTime();
    // }

}
