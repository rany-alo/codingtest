<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ExporterCsv 
{
    public function __construct(private EntityManagerInterface $em, private SerializerInterface $serializerInterface)
    {
        $this->em = $em;
        $this->serializerInterface = $serializerInterface;
    }

    public function export($entity): Response
    {
        
        $data = $this->em->getRepository($entity::class)->findAll();
        $csvContent = $this->serializerInterface->serialize($data, 'csv', ['groups' => 'list_questions']);
    
        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'application/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="exporting.csv"');

        return $response;
    }
}