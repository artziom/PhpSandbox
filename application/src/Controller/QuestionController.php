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
        return new Response("Hello World");
    }

    #[Route("/questions/{slug}")]
    public function show($slug): Response
    {
        $answers = [
            "Turn off and turn on",
            "Use Google",
            "But why?"
        ];

        return $this->render("question/show.html.twig", [
            'question' => ucwords(str_replace("-", " ", $slug)),
            'answers' => $answers
        ]);
    }
}