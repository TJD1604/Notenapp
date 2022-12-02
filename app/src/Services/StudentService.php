<?php

namespace App\Services;

use App\Entity\Student;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Grade;
class StudentService{

    public function putAverageInTable(int $studentID, ManagerRegistry $doctrine){
        $gradesService = new GradesService();
        $entityManager = $doctrine->getManager();

        $studentGrades = $entityManager->getRepository(Grade::class)->findBy(Array('studentId'=>$studentID));
        $average = $this->getAverage($studentGrades, $gradesService);

        $student = $entityManager->getRepository(Student::class)->find($studentID);
        $student->setAverage($average);

        $entityManager->flush();
    }

    private function getAverage(array $studentGrades, GradesService $gradesService){
        $grades = array();
        foreach ($studentGrades as $grade){
            $grades [] = $grade->getValue();
        }

        $average = $gradesService->getAverage($grades);

        return $average;
    }

}