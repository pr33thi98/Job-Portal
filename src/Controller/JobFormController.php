<?php

namespace App\Controller;
use App\Entity\Jobs;
use App\Entity\Admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobsRepository;
use App\Repository\AdminRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\JobsType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Type\Integer;
use App\Class\Producer;
class JobFormController extends AbstractController
{
    
    #[Route('/job/form/{id}', name: 'app_job_form')]
    public function index(Request $request,JobsRepository $repo, EntityManagerInterface $entityManager,ValidatorInterface $validator,AdminRepository $repo1,$id=''): Response
    {
        if($id)
        {
            
            $data = $repo->find($id);

	    $description = "job edited";
        }
        else
        {
            $data = new Jobs();

	    $description = "Job posted ";

        }
        $form = $this->createForm(JobsType::class, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date =  new \DateTime('@'.strtotime('now'));

            $data->setcreated_at($date);

            $data->setmodified_at($date);

            $entityManager->persist($data);

            $entityManager->flush();

            $jobId = $data->getId();

            $type = 1;

           
            $obj = new Producer();

            // $userId = 1;

            $userId = '';
            
            $obj->producerConfig($userId, $date, $jobId, $type, $description);
            

        }
        return $this->render('job_form/index.html.twig', [
                       
            'JobsForm' => $form->createView(),

           
        ]);       
   }
}
