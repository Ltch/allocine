<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Session\Session;



class UsersController extends AbstractController
{

    /**
     * @Route("/users", name="users")
     */
    public function login(Request $request)
    {
      $form = $this->createFormBuilder()
            ->add('login', TextType::class, array('label' => 'Login'))
            ->add('password', PasswordType::class, array('label' => 'mot de passe'))
            ->add('submit', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid())
      {
        $data = $form->getData();

        $em = $this->getDoctrine()->getManager();

          $RAW_QUERY = 'SELECT * FROM users where login = "'. $data['login'] .'";';
          $statement = $em->getConnection()->prepare($RAW_QUERY);
          $statement->execute();

          $result = $statement->fetchAll();

          if ($result[0]['login'] == $data['login'] && password_verify($data['password'],$result[0]['password']))
          {
            session_destroy();

            $session = new Session();
            $session->set('name', $data['login']);
            $session->start();
            //var_dump($session->getName());

            return $this->redirectToRoute('index');
          }
          else
          {
            return $this->render('users/login.html.twig', array('form' => $form->createView(), "error" => 'Login ou mot de passe invalide ..'));
          }
      }
      return $this->render('users/login.html.twig',array("form" => $form->createView()));
    }

    public function sign(Request $request)
    {
      $form = $this->createFormBuilder()
            ->add('login', TextType::class, array('label' => 'Login'))
            ->add('password', PasswordType::class, array('label' => 'mot de passe'))
            ->add('confirm_password', PasswordType::class, array('label' => 'Confirmation mot de passe'))
            ->add('submit', SubmitType::class, array('label' => 'Envoyer'))
            ->getForm();

      $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
              $data = $form->getData();

              if ($data["password"] == $data['confirm_password'])
              {
                $em = $this->getDoctrine()->getManager();

                  $RAW_QUERY = 'SELECT login FROM users where login = "'. $data['login'] .'";';
                  $statement = $em->getConnection()->prepare($RAW_QUERY);
                  $statement->execute();
                  $result = $statement->fetchAll();
                  if (count($result) == 0)
                  {

                    $mdp = password_hash($data["password"], PASSWORD_DEFAULT);
                    $db = $this->getDoctrine()->getManager();

                    $users = new Users();
                    $users->setLogin($data["login"]);
                    $users->setPassword($mdp);
                    $db->persist($users);
                    $db->flush();
                      return $this->redirectToRoute('login', array());
                  }
                  else
                  {
                    return $this->render('users/sign.html.twig', array('error' => 'Login déjà existant', 'form' => $form->createView()));
                  }
              }
              else
              {
                return $this->render('users/sign.html.twig', array('form'=> $form->createView(), 'error' => 'Les deux mots de passe ne corresponde pas..'));
              }

              return $this->render('users/login.html.twig', array('test' => $data));
            }

      return $this->render("users/sign.html.twig", array('form' => $form->createView()));
    }

    public function log_out(Session $session)
    {
      $session->clear();
      return $this->redirectToRoute('index');
    }
}
