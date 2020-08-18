<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvitationRepository::class)
 */
class Invitation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_sender;

    /**
     * @ORM\ManyToOne(targetEntity=user::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_invited;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $accept;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cancel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function settId(?user $id): self
    {
        $this->id = $id;
        return $this;
    }


    public function getUserSender(): ?user
    {
        return $this->user_sender;
    }

    public function setUserSender(?user $user_sender): self
    {
        $this->user_sender = $user_sender;

        return $this;
    }

    public function getUserInvited(): ?user
    {
        return $this->user_invited;
    }

    public function setUserInvited(?user $user_invited): self
    {
        $this->user_invited = $user_invited;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getAccept(): ?bool
    {
        return $this->accept;
    }

    public function setAccept(bool $accept): self
    {
        $this->accept = $accept;

        return $this;
    }

    public function getCancel(): ?bool
    {
        return $this->cancel;
    }

    public function setCancel(bool $cancel): self
    {
        $this->cancel = $cancel;

        return $this;
    }
}
