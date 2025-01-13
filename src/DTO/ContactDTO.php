<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO 
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public string $name = '';

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email = '';

    #[Assert\NotBlank]
    #[Assert\Length(min: 10, max: 1000)]
    public string $message = '';

    #[Assert\NotBlank]
    public string $service = '';

    // public function __construct(string $name, string $email, string $message)
    // {
    //     $this->name = $name;
    //     $this->email = $email;
    //     $this->message = $message;
    // }

    // public function getName(): string
    // {
    //     return $this->name;
    // }

    // public function getEmail(): string
    // {
    //     return $this->email;
    // }

    // public function getMessage(): string
    // {
    //     return $this->message;
    // }
}
