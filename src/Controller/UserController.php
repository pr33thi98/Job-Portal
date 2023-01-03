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

class UserController extends AbstractController
{
    #[Route('/userLogin', name: 'app_user_login')]
    public function userLogin(Request $request, UserRepository $repo, ValidatorInterface $validator): Response
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
        $result = 0;
        $userId = null;
        $dataRead = $repo->loginAuthentication($username);
        if ($dataRead != false)
        {
            if($password == $dataRead['password'])
            {
                $result = 1;
                $userId = $dataRead['id'];
            }
        }
        $response = ["result"=>$result, "id"=>$userId ];
        return new Response($response);
    }

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
        $count = $repo->recordCount();
        $response = new JsonResponse(["listData"=>$jobList, "total"=> $count]);
        return $response;
    }

    #[Route('/checkLogin', name: 'app_user_check')]
    public function checkUser(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user=$this->getUser();
        print_r($user); 
        die();
        $response = new JsonResponse([$user]);
        return $response;
    }

    #[Route('/apply', name: 'app_user_apply')]
    public function application(Request $request,EntityManagerInterface $entityManager):Response
    {
            try
            {
                $uploadedFile = json_decode($request->files->get('file'),true);
                // $content = json_decode($request->getContent(),true);
                // $email = $content['email'] ;
                $email = "preethi@gmail.com";
                $userId = 1;
                $jobId = 6;
                // $sortField = $content['sortField'] ;
                if ( $uploadedFile == null)
                {
                    $message = 0;
                    $output = array('message'  => $message);
                    $response = new JsonResponse($output);
                    return $response;
                }
                else
                {
                    $name = $request->files->get('file')->getClientOriginalName();
                    $date = new \DateTime('@'.strtotime('now'));
                    $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
                    // $uploadSuccess = $uploadedFile->move($destination, $uploadedFile->getClientOriginalName().time());                    
                    $application = new Application();
                    $id = $application->getId();
                    $application->setUserId($userId);
                    $application->setJobId($jobId);
                    $application->setAppliedAt($date);
                    $application->setResume($name);
                    $application->setEmail($email);
                    $entityManager->persist($application);
                    $entityManager->flush();
                   
                    $message = 'file Uploaded';
                    $output = array(
                            'message'  => $message,
                            'id'=>$id,       
                    );
                    $response = new JsonResponse($output);
                    return $response;
            }
        }
            catch(\Exception $e)
            {
                $message =  $e->getMessage();
                $output = array(
                'message'  => $message,
                'error' =>$e
                );
                $response = new JsonResponse($output);
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
            
            $applicationList = $repo->getApplication($pageNo, $userId);
            $count = $repo->recordCount();
            $response = new JsonResponse(["listData"=>$applicationList, "total"=> $count]);
            return $response;
        }
}