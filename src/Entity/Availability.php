<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
class Availability
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $consultation_duration = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $mon_start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $mon_end_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $tue_start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $tue_end_hour = null;


    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $wed_end_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $thu_start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $thu_end_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sat_start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sat_end_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fri_start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fri_end_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sun_start_hour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $sun_end_hour = null;

    #[ORM\OneToOne(inversedBy: 'availability', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Doctor $doctor = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $wed_start_hour = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsultationDuration(): ?int
    {
        return $this->consultation_duration;
    }

    public function setConsultationDuration(int $consultation_duration): static
    {
        $this->consultation_duration = $consultation_duration;

        return $this;
    }

    public function getMonStartHour(): ?\DateTimeInterface
    {
        return $this->mon_start_hour;
    }

    public function setMonStartHour(\DateTimeInterface $mon_start_hour): static
    {
        $this->mon_start_hour = $mon_start_hour;

        return $this;
    }

    public function getMonEndHour(): ?\DateTimeInterface
    {
        return $this->mon_end_hour;
    }

    public function setMonEndHour(?\DateTimeInterface $mon_end_hour): static
    {
        $this->mon_end_hour = $mon_end_hour;

        return $this;
    }

    public function getTueStartHour(): ?\DateTimeInterface
    {
        return $this->tue_start_hour;
    }

    public function setTueStartHour(?\DateTimeInterface $tue_start_hour): static
    {
        $this->tue_start_hour = $tue_start_hour;

        return $this;
    }

    public function getTueEndHour(): ?\DateTimeInterface
    {
        return $this->tue_end_hour;
    }

    public function setTueEndHour(?\DateTimeInterface $tue_end_hour): static
    {
        $this->tue_end_hour = $tue_end_hour;

        return $this;
    }


    public function getWedEndHour(): ?\DateTimeInterface
    {
        return $this->wed_end_hour;
    }

    public function setWedEndHour(?\DateTimeInterface $wed_end_hour): static
    {
        $this->wed_end_hour = $wed_end_hour;

        return $this;
    }

    public function getThuStartHour(): ?\DateTimeInterface
    {
        return $this->thu_start_hour;
    }

    public function setThuStartHour(?\DateTimeInterface $thu_start_hour): static
    {
        $this->thu_start_hour = $thu_start_hour;

        return $this;
    }

    public function getThuEndHour(): ?\DateTimeInterface
    {
        return $this->thu_end_hour;
    }

    public function setThuEndHour(?\DateTimeInterface $thu_end_hour): static
    {
        $this->thu_end_hour = $thu_end_hour;

        return $this;
    }

    public function getSatStartHour(): ?\DateTimeInterface
    {
        return $this->sat_start_hour;
    }

    public function setSatStartHour(?\DateTimeInterface $sat_start_hour): static
    {
        $this->sat_start_hour = $sat_start_hour;

        return $this;
    }

    public function getSatEndHour(): ?\DateTimeInterface
    {
        return $this->sat_end_hour;
    }

    public function setSatEndHour(?\DateTimeInterface $sat_end_hour): static
    {
        $this->sat_end_hour = $sat_end_hour;

        return $this;
    }

    public function getFriStartHour(): ?\DateTimeInterface
    {
        return $this->fri_start_hour;
    }

    public function setFriStartHour(?\DateTimeInterface $fri_start_hour): static
    {
        $this->fri_start_hour = $fri_start_hour;

        return $this;
    }

    public function getFriEndHour(): ?\DateTimeInterface
    {
        return $this->fri_end_hour;
    }

    public function setFriEndHour(?\DateTimeInterface $fri_end_hour): static
    {
        $this->fri_end_hour = $fri_end_hour;

        return $this;
    }

    public function getSunStartHour(): ?\DateTimeInterface
    {
        return $this->sun_start_hour;
    }

    public function setSunStartHour(?\DateTimeInterface $sun_start_hour): static
    {
        $this->sun_start_hour = $sun_start_hour;

        return $this;
    }

    public function getSunEndHour(): ?\DateTimeInterface
    {
        return $this->sun_end_hour;
    }

    public function setSunEndHour(?\DateTimeInterface $sun_end_hour): static
    {
        $this->sun_end_hour = $sun_end_hour;

        return $this;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getWedStartHour(): ?\DateTimeInterface
    {
        return $this->wed_start_hour;
    }

    public function setWedStartHour(?\DateTimeInterface $wed_start_hour): static
    {
        $this->wed_start_hour = $wed_start_hour;

        return $this;
    }
}
