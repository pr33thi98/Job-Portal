<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Application;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ApplicationRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\KernelInterface;
class ViewResumeController extends AbstractController
{
    #[Route('/view/resume/{id}', name: 'app_view_resume')]
    public function index($id,ApplicationRepository $repo,KernelInterface $kernel){
        
        $data = $repo->find($id);

        $name = $data ->getResume();

        $this->projectDir = $kernel->getProjectDir();

        $path = $this->projectDir.'/public/uploads/'.$name;

        $response = new BinaryFileResponse ( $path );
        
        return $response;
       
    }
}
