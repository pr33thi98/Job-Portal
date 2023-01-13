<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use App\Repository\JobsRepository;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Application;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Security\Authenticator\ExampleAuthenticator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
use App\Security\SecurityAuthenticator;


class UserController extends AbstractController
{

    // public function __construct( private FormLoginAuthenticator $authenticator) 
    // {
    //     $this->authenticator = $authenticator;
    // }

    #[Route('/api/login', name: 'app_login')]
    public function index(Request $request, UserRepository $repo, ValidatorInterface $validator, UserAuthenticatorInterface $userAuthenticator, SecurityAuthenticator $authenticator, EntityManagerInterface $entityManager,UserInterface $user, JWTTokenManagerInterface $JWTManager): Response
    {
        $data = json_decode($request->getContent(),true);
        $username = $data['username'];
        $password = $data['password'];
        $constraint = new Assert\Collection([
            'fields' => [
                'username' => [new Assert\NotBlank([
                    'message' => 'The username is not provided.',
                ])],
                'password' => [new Assert\NotBlank([
                        'message' => 'The password is not provided.',
                    ])],
                    ],
            'allowExtraFields' => true,
            'allowMissingFields' => false]);
        
        $violations = $validator->validate($data, $constraint);
                
        if (count($violations) > 0) 
        {
            $errorsString = (string) $violations;
            return new Response($errorsString);
        }       
        $user=$repo->findOneBy(['username'=>$username]);
        if ($user != null)
        {
            if($password == $user->getPassword())
            {
                $userId = $user->getId();
                // csrf_token('authenticate');
                // $token = base64_encode(json_encode([$userId = $user->getId() , $username = $user->getUsername()]));

                // $token = json_encode([$userId = $user->getId() , $username = $user->getUsername()]);

                // $response = new JsonResponse([
                //     'token' => $token
                // ]);
                    //     $response = new JsonResponse(["result"=>$result, "id"=>$userId ]);
                // $userAuthenticator->authenticateUser(
                //                     $user, 
                //                     $authenticator, 
                //                     $request); 
                // $userr =$this->getUser();
                // $response = new JsonResponse([
                //     'token' => $token
                // ]);


                // return $response;
                // echo("hai");
                // die();

                // return new JsonResponse(['token' => $JWTManager->create($user)]);
            }
        }
        return new Response("Failed");
        
    }



    // public function userLogin(Request $request, UserRepository $repo, ValidatorInterface $validator, SecurityAuthenticator $authenticator, UserAuthenticatorInterface $userAuthenticator, 
    // SecurityAuthenticator $formAuthenticator): Response
    // {
    //     $data = json_decode($request->getContent(),true);
    //     $response = new JsonResponse(["result"=>$this->getUser()]);
    //     return $response;
    //     // print_r($this->getUser());
    //     // exit();
    //     $username = $data['username'];
    //     $password = $data['password'];
    //     $constraint = new Assert\Collection([
    //         'fields' => [
    //             'username' => [new Assert\NotBlank([
    //                 'message' => 'The username is not provided.',
    //             ])],
    //             'password' => [new Assert\NotBlank([
    //                 'message' => 'The password is not provided.',
    //             ])],
    //         ],
    //         'allowExtraFields' => true,
    //         'allowMissingFields' => false]);

    //     $violations = $validator->validate($data, $constraint);
        
    //     if (count($violations) > 0) 
    //     {
    //         $errorsString = (string) $violations;
    //         return new Response($errorsString);
    //     }       
    //     $result = 0;
    //     $userId = 0;
    //     $user=$repo->findOneBy(['username'=>$username]);
        

    //     if ($user != null)
    //     {
    //         if($password == $user->getPassword())
    //         {
    //             $userId = $user->getId();
    //             $result = 1;
    //             // $response = $security->login($user);
    //             return $userAuthenticator->authenticateUser(
    //                 $user, 
    //                 $authenticator, 
    //                 $request); 

    //         }
    //     }

    //     $response = new JsonResponse(["result"=>$result, "id"=>$userId ]);
    //     return $response;
    // }

    #[Route('/listJob', name: 'app_user_listJob')]
    public function userListJob(Request $request, JobsRepository $repo, ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(),true);
        $pageNo = $data['pageNo'];
        $searchPost = $data['searchPost'];

        $constraint = new Assert\Collection([
        'fields' => [
            'pageNo' => [new Assert\NotBlank([
            'message' => 'The username is not provided.',
        ]), new Assert\Type([
            'type' => 'integer',
            'message' => 'The page number is not a valid {{ type }}.',
        ])]
            ],
            'allowExtraFields' => true,
            'allowMissingFields' => false,
        ]);

        $violations = $validator->validate($data, $constraint);
    
        if (count($violations) > 0) 
        {
            $errorsString = (string) $violations;
            return new Response($errorsString);
        }        

        $jobList = $repo->getJobs($pageNo, $searchPost);
        $count = $repo->recordCount($searchPost);
        $response = new JsonResponse(["listData"=>$jobList, "total"=> $count]);
        return $response;
    }

    #[Route('/checkLogin', name: 'app_user_check')]
    public function checkUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$this->getUser();
        $response = new JsonResponse([$user]);
        return $response;
    }

    #[Route('/apply', name: 'app_user_apply')]
    public function application(Request $request,EntityManagerInterface $entityManager):Response
    {
        try
        {
            $uploadedFile = $request->files->get('file');
            $email = $request->request->get('email');
            $jobId = $request->request->get('jobId');
            $userId = 1;
            if ( $uploadedFile == null)
            {
                return new JsonResponse(['message'  => 'Resume not uploaded!']);
            }
            else
            {
                $name = $request->files->get('file')->getClientOriginalName();
                $date = new \DateTime('@'.strtotime('now'));
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                $application = new Application();
                $id = $application->getId();
                $application->setUserId($userId);
                $application->setJobId($jobId);
                $application->setAppliedAt($date);
                $application->setResume($name);
                $application->setEmail($email);
                $entityManager->persist($application);
                $entityManager->flush();
                 
                return new JsonResponse(['message' => 'Applied Successfully!']);
            }
        }
        catch(\Exception $e)
        {
            $response = new JsonResponse(['message' => $e->getMessage()]);
            return $response;
        }
    }
        
    #[Route('/listApplications', name: 'app_user_listApplications')]
    public function userListApplications(Request $request, ApplicationRepository $repo, UserRepository $userRepo, JobsRepository $jobRepo , ValidatorInterface $validator): Response
    {
        $data = json_decode($request->getContent(),true);
        $pageNo = $data['pageNo'];
        // $userId = $data['userId'];
        $jobId = 6;
        $userId = 1;

        $constraint = new Assert\Collection([
            'fields' => [
                'pageNo' => [new Assert\NotBlank([
                'message' => 'The username is not provided.',
                ]), new Assert\Type([
                    'type' => 'integer',
                    'message' => 'The page number is not a valid {{ type }}.',
                ])]
            ],
            'allowExtraFields' => true,
            'allowMissingFields' => false,
        ]);

        $violations = $validator->validate($data, $constraint);
        
        if (count($violations) > 0) 
        {
            $errorsString = (string) $violations;
            return new Response($errorsString);
        }        

        $applicant = $userRepo->fetchUser($userId);
        $job = $jobRepo->fetchJob($jobId);
            
        $applicationList = $repo->getApplication($pageNo, $userId, $jobId);
        $count = $repo->recordCount($userId);
        $response = new JsonResponse(["listData"=>$applicationList, "total"=> $count]);
        return $response;
    }

    #[Route('/userRegister', name: 'app_user_register')]
    public function register(Request $request,EntityManagerInterface $entityManager, ValidatorInterface $validator, UserRepository $repo):Response
    {
        $data = json_decode($request->getContent(),true);
        $uname = $data['uname'];
        $fname = $data['fname'];
        $lname = $data['lname'];
        $dob = date($data['dob']);
        $city = $data['city'];
        $phone = $data['phone'];
        $password = $data['password'];

        $constraint = new Assert\Collection([
            'fields' => [
                'uname' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])],
            'fname' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])],
            'lname' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])],
            'dob' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])],
            'city' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])],
            'phone' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])],
            'password' => [new Assert\NotBlank([
                'message' => 'The page number is not provided.',
            ])]],
            'allowExtraFields' => true,
            'allowMissingFields' => false
        ]);

        $violations = $validator->validate($data, $constraint);
    
        if (count($violations) > 0) 
        {
            $errorsString = (string) $violations;
            return new Response($errorsString);
        }

        $userCheck=$repo->findOneBy(['username'=>$uname]);

        if($userCheck != null)
            return new Response(0);

        $user = new User();
        $user->setUsername($uname);
        $user->setFirstName($fname);
        $user->setLastName($lname);
        $date = new \DateTime($dob);
        $user->setDob($date);
        $user->setCity($city);
        $user->setPhone($phone);
        $user->setPassword(
            // $userPasswordHasher->hashPassword(
            // $user,
            $password
        // )
        );
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response(1);
    }
}