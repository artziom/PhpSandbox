<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route("/", name: "app_homepage")]
    public function homepage(): Response
    {
        return $this->render('question/homepage.html.twig');
    }

    #[Route("/questions/{slug}", name: "app_question_show")]
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