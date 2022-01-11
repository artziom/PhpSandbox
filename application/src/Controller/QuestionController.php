<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route("/")]
    public function homepage(): Response
    {
        return $this->render("base.html.twig");
    }

    #[Route("/questions/{slug}")]
    public function show($slug): Response
    {
        return new Response(sprintf("Future page to show a question \"%s\"!",
            ucwords(str_replace("-", " ", $slug))
        ));
    }
}