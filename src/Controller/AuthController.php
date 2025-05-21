<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthController extends AbstractController{
    #[Route('/registration', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher, UserRepository $userRepo): Response{
        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $errors = [];

            if (empty($data['username'])) {
                $errors[] = 'Имя пользователя обязательно.';
            }
            if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Некорректный email.';
            } elseif ($userRepo->findByEmail($data['email'])) {
                $errors[] = 'Email уже используется.';
            }
            if (empty($data['password']) || strlen($data['password']) < 6) {
                $errors[] = 'Пароль должен быть не менее 6 символов.';
            }
            if (empty($errors)) {
                $user = new User();
                $user->setUsername($data['username']);
                $user->setEmail($data['email']);
                $user->setPhone($data['phone']);
                $user->setRole('User');
                $user->setPassword($hasher->hashPassword($user, $data['password']));
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_login');
            }
            return $this->render('register.html.twig', ['errors' => $errors, 'old' => $data]);
        }
        return $this->render('register.html.twig', ['errors' => null]);
    }

    #[Route('/entrance', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request, UserRepository $userRepo, SessionInterface $session, UserPasswordHasherInterface $hasher): Response{
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $password = $request->request->get('password');
            $user = $userRepo->findByUsername($username);
            if ($user && $hasher->isPasswordValid($user, $password)) {
                $session->set('user', [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'role' => $user->getRole()
                ]);
                return $this->redirectToRoute('app_profile');
            }
            return $this->render('login.html.twig', ['error' => 'Неверный логин или пароль.']);
        }
        return $this->render('login.html.twig', ['error' => null]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(SessionInterface $session, UserRepository $userRepo): Response {
        if (!$session->has('user')) {
            return $this->redirectToRoute('app_login');
        }
        $userData = $session->get('user');
        $user = $userRepo->find($userData['id']); 
        return $this->render('profile.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(SessionInterface $session): Response{
        $session->clear();
        return $this->redirectToRoute('/');
    }
}
