<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Repository\GradesRepository;
use App\Repository\StudentRepository;
use App\Services\StudentService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

#[Route('/api/grades')]
class GradeController extends AbstractController
{
    #[Route('', name: 'app_grade_index', methods: ['GET'])]
    public function index(GradesRepository $gradesRepository): Response
    {
        $allGrades = $this->normalize($gradesRepository->findAll());
        return new JsonResponse($allGrades, 200);
    }

    #[Route('', name: 'app_grade_new', methods: ['POST'])]
    public function new(Request $request, GradesRepository $gradesRepository, StudentRepository $studentRepository, StudentService $studentService, ManagerRegistry $managerRegistry): Response
    {
        $grade = new Grade();
        $content = json_decode($request->getContent(), true);

        $grade->setStudentId($content['studentId']);
        $grade->setArt($content['art']);
        $grade->setValue($content['value']);

        $student = $this->normalize($studentRepository->findOneBy(Array('id' => $content['studentId'])));

        if(empty($student)){
            return new Response('Student not found',status: 500);
        }

        $gradesRepository->save($grade, true);

        $studentService->putAverageInTable($content['studentId'], $managerRegistry);

        return new Response(status: 201);

    }

    private function normalize(mixed $data){
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $serialized = $serializer->serialize($data, 'json');
        return json_decode($serialized);

    }

}
