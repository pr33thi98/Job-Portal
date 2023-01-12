<?php

namespace App\Entity;

use App\Repository\LogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $log_time = null;

    #[ORM\Column(nullable: true)]
    private ?int $job_id = null;

    #[ORM\Column(length: 100)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $module = null;

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

    public function getLogTime(): ?\DateTimeInterface
    {
        return $this->log_time;
    }

    public function setLogTime(\DateTimeInterface $log_time): self
    {
        $this->log_time = $log_time;

        return $this;
    }

    public function getJobId(): ?int
    {
        return $this->job_id;
    }

    public function setJobId(?int $job_id): self
    {
        $this->job_id = $job_id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getModule(): ?int
    {
        return $this->module;
    }

    public function setModule(int $module): self
    {
        $this->module = $module;

        return $this;
    }
}
