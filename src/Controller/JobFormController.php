<?php

namespace App\Controller;
use App\Entity\Jobs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\JobsRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\JobsType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;
class JobFormController extends AbstractController
{
    
    #[Route('/job/form/{id}', name: 'app_job_form')]
    public function index(Request $request,JobsRepository $repo, EntityManagerInterface $entityManager,$id=''): Response
    {
        if($id)
        {

            $data = $repo->find($id);
        } 
        else
        {
            $data = new Jobs();
        }
        $form = $this->createForm(JobsType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date =  new \DateTime('@'.strtotime('now'));
            $data->setcreated_at($date);
            $data->setmodified_at($date);
            $entityManager->persist($data);
            $entityManager->flush();
        }
        return $this->render('job_form/index.html.twig', [
                        'JobsForm' => $form->createView(),
        ]);       
   }
}
