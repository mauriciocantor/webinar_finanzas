<?php

namespace App\Service\Report;

use App\Entity\User;
use App\Repository\ModuleVideoRepository;
use App\Repository\UserRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Report
{
    private ModuleVideoRepository $moduleVideoRepository;
    private UserRepository $userRepository;

    public function __construct(ModuleVideoRepository $moduleVideoRepository, UserRepository $userRepository)
    {
        $this->moduleVideoRepository = $moduleVideoRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @return Xls
     */
    public function getReport(User $user): Xls
    {
        $report = $this->moduleVideoRepository->getVideoCorrectByUser($user);
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $this->getTitleTable($activeWorksheet, $user);
        $this->getBodyTable($report, $activeWorksheet);

        //        $write->save('Report videos correctos');
        return new Xls($spreadsheet);
    }

    /**
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeWorksheet
     * @param User $user
     * @return void
     */
    public function getTitleTable(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeWorksheet, User $user): void
    {
        $activeWorksheet->setCellValue('A1', 'Reporte de videos correctos: ' . $user->getEmail());
        $activeWorksheet->setCellValue('A3', 'Nombre de Semana');
        $activeWorksheet->setCellValue('B3', 'Nombre Video');
        $activeWorksheet->setCellValue('C3', 'Correctos Ahorcado');
        $activeWorksheet->setCellValue('D3', 'Correctos Sopa de Letras');
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->getColumnDimension('A')->setWidth(18);
        $activeWorksheet->getColumnDimension('B')->setWidth(14);
        $activeWorksheet->getColumnDimension('C')->setWidth(18);
        $activeWorksheet->getColumnDimension('D')->setWidth(22);
    }

    /**
     * @param mixed $report
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeWorksheet
     * @return void
     */
    public function getBodyTable(mixed $report, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $activeWorksheet): void
    {
        $currentRow = 4;
        foreach ($report as $index => $info) {
            $activeWorksheet->setCellValue('A' . ($index + $currentRow), $info['name']);
            $activeWorksheet->setCellValue('B' . ($index + $currentRow), $info['Video']);
            $activeWorksheet->setCellValue('C' . ($index + $currentRow), $info['Hangman_Correct'] ?? 0);
            $activeWorksheet->setCellValue('D' . ($index + $currentRow), $info['Soup_Correct'] ?? 0);
        }
    }

    public function getReportAlphabetSoup(){
        $report = $this->userRepository->getAllUserAlphabetSoupCorrect();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Reporte de videos de Sopa de Letras');
        $activeWorksheet->setCellValue('A3', 'Email');
        $activeWorksheet->setCellValue('B3', 'Grupo');
        $activeWorksheet->setCellValue('C3', 'Palabras Encontradas');
        $activeWorksheet->setCellValue('D3', 'Palabras de la Sopa de Letras');
        $activeWorksheet->setCellValue('E3', 'Semana');
        $activeWorksheet->setCellValue('F3', 'Video');
        $activeWorksheet->setCellValue('G3', 'Preguntas');
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->getColumnDimension('A')->setWidth(18);
        $activeWorksheet->getColumnDimension('B')->setWidth(14);
        $activeWorksheet->getColumnDimension('C')->setWidth(18);
        $activeWorksheet->getColumnDimension('D')->setWidth(22);

        $currentRow = 4;
        foreach ($report as $index => $info) {
            if(implode( ',', $info['roles']) == 'ROLE_ADMIN'){
                $currentRow--;
                continue;
            }
            $activeWorksheet->setCellValue('A' . ($index + $currentRow), $info['email']);
            $activeWorksheet->setCellValue('B' . ($index + $currentRow), $this->getGroupByRoles(implode( ',', $info['roles'])));
            $activeWorksheet->setCellValue('C' . ($index + $currentRow), implode(',', $info['foundWord']));
            $activeWorksheet->setCellValue('D' . ($index + $currentRow), implode(',', $info['words'] ));
            $activeWorksheet->setCellValue('D' . ($index + $currentRow), $info['name']);
            $activeWorksheet->setCellValue('D' . ($index + $currentRow), $info['video']);
            $activeWorksheet->setCellValue('D' . ($index + $currentRow), implode(',',$info['question'] ));
        }

        return new Xls($spreadsheet);
    }

    public function getReportHangman(){
        $report = $this->userRepository->getAllUserHangmanCorrect();
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Reporte de videos de Sopa de Letras');
        $activeWorksheet->setCellValue('A3', 'Email');
        $activeWorksheet->setCellValue('B3', 'Grupo');
        $activeWorksheet->setCellValue('C3', 'Palabra Correcta');
        $activeWorksheet->setCellValue('D3', 'Palabra para buscar');
        $activeWorksheet->setCellValue('E3', 'Semana');
        $activeWorksheet->setCellValue('F3', 'Video');
        $activeWorksheet->setCellValue('G3', 'Pregunta');
        $activeWorksheet->mergeCells('A1:D1');
        $activeWorksheet->getColumnDimension('A')->setWidth(40);
        $activeWorksheet->getColumnDimension('B')->setWidth(14);
        $activeWorksheet->getColumnDimension('C')->setWidth(20);
        $activeWorksheet->getColumnDimension('D')->setWidth(20);
        $activeWorksheet->getColumnDimension('E')->setWidth(12);
        $activeWorksheet->getColumnDimension('F')->setWidth(14);
        $activeWorksheet->getColumnDimension('G')->setWidth(35);

        $currentRow = 4;
        foreach ($report as $index => $info) {
            if(implode( ',', $info['roles']) == 'ROLE_ADMIN'){
                $currentRow--;
                continue;
            }
            $activeWorksheet->setCellValue('A' . ($index + $currentRow), $info['email']);
            $activeWorksheet->setCellValue('B' . ($index + $currentRow), $this->getGroupByRoles(implode( ',', $info['roles'])));
            $activeWorksheet->setCellValue('C' . ($index + $currentRow), $info['text']);
            $activeWorksheet->setCellValue('D' . ($index + $currentRow), implode(',', $info['dictionary'] ));
            $activeWorksheet->setCellValue('E' . ($index + $currentRow), $info['name']);
            $activeWorksheet->setCellValue('F' . ($index + $currentRow), $info['video']);
            $activeWorksheet->setCellValue('G' . ($index + $currentRow), $info['question']);
        }

        return new Xls($spreadsheet);
    }

    public function getGroupByRoles($role){
        $group = '';
        switch ($role){
            case 'ROLE_ADMIN':
                $group='Administración';
                break;
            case 'ROLE_PLATINUM':
                $group='Grupo 3';
                break;
            case 'ROLE_SILVER':
                $group='Grupo 1';
                break;
            case 'ROLE_GOLDEN':
                $group='Grupo 2';
                break;
        }

        return $group;
    }

}