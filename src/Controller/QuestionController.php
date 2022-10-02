<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    #[Route('/question/show', name: 'app_question_show', methods:['GET'])]
    public function questionsShow(QuestionRepository $questionRepository, SerializerInterface $serializerInterface): Response
    {
        $question = $questionRepository->findAll();

        $jsonContent = $serializerInterface->serialize($question, 'json', ['groups' => 'list_questions']);
    
        $response = new Response($jsonContent);
    
        $response->headers->set('Content-Type', 'application/json');
    
        return $response;
        
    }
    #[Route('/question/add', name: 'app_question_add', methods:['POST'])]
    public function questionAdd(Request $request, EntityManagerInterface $em): Response
    {
        // if($request->isXmlHttpRequest()) {

            $question = new Question();

            $recContent = $request->getContent();

            $data = json_decode($recContent);

            $question->setTitle($data->title);
            $question->setPromoted($data->promoted);
            $question->setStatus($data->status);

            
            $question->setCreatedAt(new \DateTimeImmutable());
            $question->setUpdatedAt(new \DateTimeImmutable());
    
            $em->persist($question);
            $em->flush();

        

            return new Response('ok', 201);
        // }
        // return new Response('Failed', 404);
        
    }
    #[Route('/question/addanswer/{id}', name: 'app_answer_add', methods:['POST'])]
    public function answerAdd($id, Request $request, QuestionRepository $questionRepository, EntityManagerInterface $em): Response
    {
        // if($request->isXmlHttpRequest()) {

            $answer = new Answer();

            $recContent = $request->getContent();

            $data = json_decode($recContent);

            $answer->setChannel($data->channel);
            $answer->setBody($data->body);
            $answer->setQuestion($questionRepository->findOneBy(["id" => $id]));

    
            $em->persist($answer);
            $em->flush();

        

            return new Response('ok', 201);
        // }
        // return new Response('Failed', 404);
        
    }
}
