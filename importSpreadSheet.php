<!DOCTYPE html>
<html>
    <head>
        <title> Food Spreadsheet </title>
    </head>
    <body>
        <table>
        <?php
        // Increase memory limit to 256MB
        ini_set('memory_limit', '256M');

        require "vendor/autoload.php";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load("Book1.xlsx");
        $worksheet = $spreadsheet->getActiveSheet();
        
        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            echo "<tr>";
            foreach ($cellIterator as $cell) {
                echo "<td>" . $cell->getValue() . "</td>";
                $cell->getWorksheet()->getCell($cell->getCoordinate())->getCalculatedValue();
                unset($cell);
            }
            unset($cellIterator);
            echo "</tr>";

            // Free up memory
            $row->getWorksheet()->garbageCollect();
            unset($row);
        }
        // Free up memory
        $worksheet->garbageCollect();
        unset($worksheet);
        unset($spreadsheet);
        ?>
        </table>
    </body>
</html>


