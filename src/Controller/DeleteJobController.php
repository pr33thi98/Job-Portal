<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Jobs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Class\Producer;
class DeleteJobController extends AbstractController
{
    #[Route('/delete/job/{id}', name: 'app_delete_job')]
    public function index(Request $request,EntityManagerInterface $entityManager,JobsRepository $repo,$id,ValidatorInterface $validator): Response
    {

        $data = $repo->findOneBy(["id"=>$id]);

	$jobId = $id;

        $entityManager->remove($data);

        $entityManager->flush();

        $message = "Job deleted";

        $obj = new Producer();

        $userId = '';

        $date = new \DateTime('@'.strtotime('now'));

        //$jobId = $data ->getId();

        $type = 1;

        $description = "job deleted";
            
        $obj->producerConfig($userId, $date, $jobId, $type, $description);
            

        $userlist = array('message'=>$message);

        $response = new JsonResponse($userlist);

        return $response;

    }
}
