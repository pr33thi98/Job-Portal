<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?int $job_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $applied_at = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $resume = null;

    #[ORM\Column(length: 30)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getJobId(): ?int
    {
        return $this->job_id;
    }

    public function setJobId(int $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }

    public function getAppliedAt(): ?\DateTimeInterface
    {
        return $this->applied_at;
    }

    public function setAppliedAt(\DateTimeInterface $applied_at): self
    {
        $this->applied_at = $applied_at;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
