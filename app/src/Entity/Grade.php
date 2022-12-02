<?php

namespace App\Entity;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use App\Controller\GradeController;
use App\Controller\GradesController;
use App\Repository\GradesRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;


#[ORM\Entity(repositoryClass: GradesRepository::class)]
#[ApiResource(operations:[
    new GET(
        name: 'app_grade_index',
        uriTemplate: '/api/grades/',
        controller: GradeController::class
    ),
    new POST(
        name: 'app_grade_new',
        uriTemplate: '/api/grades/',
        controller: GradeController::class
    ),
    new Put(),
    new Delete()
]
)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $studentId = null;

    #[ORM\Column(length: 255)]
    private ?string $art = null;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): self
    {
        $this->studentId = $studentId;

        return $this;
    }

    public function getArt(): ?string
    {
        return $this->art;
    }

    public function setArt(string $art): self
    {
        $this->art = $art;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
