<?php

namespace App\Controller;
use App\Entity\Jobs;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\JobsType;
class JobFormController extends AbstractController
{
    #[Route('/job/form', name: 'app_job_form')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobs = new Jobs();

        // print_r($jobs);

        $form = $this->createForm(JobsType::class, $jobs);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date =  new \DateTime('@'.strtotime('now'));

            $jobs->setCreatedAt($date);

            $jobs->setModifiedAt($date);

            $entityManager->persist($jobs);

            $entityManager->flush();
        }

        return $this->render('job_form/index.html.twig', [
            
            'JobsForm' => $form->createView(),
        ]);
    }
}
