<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: App\Repository\UserRepository::class)]
#[ORM\Table(name: 'userinfo')]
class User implements UserInterface, PasswordAuthenticatedUserInterface{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private string $username;

    #[ORM\Column(length: 255, unique: true)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $password;

    #[ORM\Column(length: 20)]
    private string $phone;

    #[ORM\Column(length: 20)]
    private string $role = 'ROLE_USER';

    public function getUserIdentifier(): string{
        return $this->username;
    }
    public function getRoles(): array{
        return [$this->role];
    }
    public function eraseCredentials(): void{
        //
    }

    public function getPassword(): string{
        return $this->password;
    }
    public function getId(): ?int{
        return $this->id;
    }
    public function setUsername(string $username): self{
        $this->username = $username;
        return $this;
    }
    public function getUsername(): string{
        return $this->username;
    }
    public function setEmail(string $email): self{
        $this->email = $email;
        return $this;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function setPhone(string $phone): self{
        $this->phone = $phone;
        return $this;
    }
    public function getPhone(): string{
        return $this->phone;
    }
    public function setRole(string $role): self{
        $this->role = $role;
        return $this;
    }
    public function getRole(): string{
        return $this->role;
    }
    public function setPassword(string $password): self{
        $this->password = $password;
        return $this;
    }
}
