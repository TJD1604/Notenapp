<?php

namespace App\Controller;


use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api/students')]
class StudentController extends AbstractController
{
    #[Route('', name: 'app_student_index', methods: ['GET'])]
    public function index(StudentRepository $studentRepository): Response
    {
        $allGrades = $this->normalize($studentRepository->findAll());

        $average = array_column($allGrades, 'average');
        array_multisort($average, SORT_ASC, $allGrades);

        return new JsonResponse($allGrades, 200);
    }

    private function normalize(mixed $data){
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $serialized = $serializer->serialize($data, 'json');
        return json_decode($serialized);

    }

}
