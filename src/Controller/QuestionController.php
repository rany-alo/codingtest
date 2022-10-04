<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\HistoricQuestion;
use App\Entity\Question;
use App\EventListener\QuestionUpdate;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\EventDispatcher\Event;

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
    public function questionAdd(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {

            $question = new Question();

            $recContent = $request->getContent();

            $data = json_decode($recContent);

            $question->setTitle($data->title);
            $question->setPromoted($data->promoted);
            $question->setStatus($data->status);

            
            $question->setCreatedAt(new \DateTimeImmutable());
            $question->setUpdatedAt(new \DateTimeImmutable());

            $errors = $validator->validate($question);

            if (count($errors) > 0) {

                $errorsString = (string) $errors;
            
                return new Response($errorsString);
            }
    
            $em->persist($question);
            $em->flush();

        

            return new Response('ok', 201);

        
    }
    #[Route('/question/addanswer/{id}', name: 'app_answer_add', methods:['POST'])]
    public function answerAdd($id, Request $request, QuestionRepository $questionRepository, 
                                EntityManagerInterface $em, ValidatorInterface $validator): Response
    {

            $answer = new Answer();

            $recContent = $request->getContent();

            $data = json_decode($recContent);

            $answer->setChannel($data->channel);
            $answer->setBody($data->body);
            $answer->setQuestion($questionRepository->findOneBy(["id" => $id]));

            $errors = $validator->validate($answer);

            if (count($errors) > 0) {

                $errorsString = (string) $errors;
            
                return new Response($errorsString);
            }

            $em->persist($answer);
            $em->flush();

        

            return new Response('ok', 201);

        
    }
    #[Route('/question/update/{id}', name: 'app_question_update', methods:['PUT'])]
    public function questionUpdate(Question $question, Request $request, EntityManagerInterface $em, ValidatorInterface $validator): Response
    {
        
            $recContent = $request->getContent();
            $data = json_decode($recContent);

        if($question->getTitle() != $data->title || $question->getStatus() != $data->status){
            $question->setTitle($data->title);
            $question->setStatus($data->status);

            
            $question->setUpdatedAt(new \DateTimeImmutable());

            $errors = $validator->validate($question);

            if (count($errors) > 0) {

                $errorsString = (string) $errors;
            
                return new Response($errorsString);
            }
            
            $em->persist($question);
            $em->flush();

            return new Response('ok', 201);
        }
        return new Response('Il faut changer le titre ou le statut', 406);

        
    }
}
