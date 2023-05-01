<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;

class UploadFilesHelper
{
    /**
     * Checks if the given temporary submission contains an excel file.
     * 
     * @param string $submissionCode Submission directory to check
     * @return bool 
     */
    public function containsExcel($submissionCode)
    {
        $files = Storage::disk('local')->files('files/temp/' . $submissionCode);
        
        foreach ($files as $fileName) {
            if (str_contains(strtolower($fileName), '.xlsx')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the designated excel sheet for a temporary submission.
     *
     * @param string $submissionCode Submission directory to check
     * @return string Excel sheet directory 
     */
    public function getSubmissionExcel($submissionCode)
    {
        for ($i = 0; $i < 2; $i++) {
            sleep(2); // wait 2 seconds for file to finish uploading and try again

            $files = Storage::disk('local')->files('files/temp/' . $submissionCode);
        
            foreach ($files as $fileName) {
                if (str_contains(strtolower($fileName), '.xlsx')) {
                    return $fileName;
                }
            }
            
            // try one more time
        }

        return '';
    }

    /**
     * Gets the filename for given file directory and submission code.
     *
     * @param string $file Directory of the file
     * @param string $submissionCode Submission directory to check
     * @return string Filename 
     */
    public function getFileName($file, $submissionCode)
    {
        return substr(explode($submissionCode, $file)[1], 1);
    }
    
    /**
     * Gets the response for the headings Returns true if the headings are correct.
     *
     * @param array $matrix Matrix of the excel sheet
     * @return array [Headings correct - Boolean , Response - array] 
     */
    public function checkHeadings($matrix)
    {
        $headingsCorrect  = true;
        $response         = [];
        $expectedHeadings = config('excel-template');
        $headings         = $matrix[0];
        
        foreach ($expectedHeadings as $heading => $headingData) {
            if (!in_array($heading, $headings)) {
                $headingsCorrect = false;
                $response[]      = "Heading '$heading' not found";
            }
        }

        return [
            $headingsCorrect,
            $response
        ];
    }

    /**
     * Cleans the document matrix to a more readable array.
     *
     * @param array $matrix Matrix of the excel sheet
     * @return array [Heading Name - [values]]
     */
    public function cleanMatrix($matrix)
    {
        $headings = config('excel-template');
        $headingMatrix = [];
        foreach ($headings as $heading => $headingData) {
            $index = array_search($heading, $matrix[0]);
            $headingMatrix[$heading] = $index;
        }

        $firstRow  = true;
        $newMatrix = [];

        foreach ($matrix as $row) {
            // skip the headings
            if ($firstRow) {
                $firstRow = false;
                continue;
            }

            $lastRow = true;
            foreach ($headings as $heading => $headingData) {
                $newMatrix[$heading][] = $row[$headingMatrix[$heading]];
                
                $lastRow = empty($row[$headingMatrix[$heading]]);
                // if all the fields for this row is empty, treat it as the last row
            }

            if ($lastRow) {
                break;
            }
        }
        
        return $newMatrix;
    }

    /**
     * Checks the data integrity of the rows. Returns false with an error
     * message if there is a wrong data type somewhere. Returns true with
     * the converted values for the matrix if everything is valid.
     *
     * @param array $matrix Matrix of the excel sheet
     * @return array
     */
    public function checkDataIntegrity($matrix)
    {
        $headings = config('excel-template');

        for ($i = 0; $i < count($matrix['No.'])-1; $i++) {
            
            foreach ($headings as $heading => $headingData) {

                // check numeric values
                if (
                    $headingData['type'] == 'int'
                    && !is_numeric($matrix[$heading][$i])
                ) {
                    return [
                        false,
                        "Data integrity violation:",
                        ["Row ".($i+2)." , heading '$heading' doesn't have a numeric value: '".$matrix[$heading][$i]."'"],
                    ];
                }

                // check forced values
                if (
                    !empty($headingData['allowed'])
                    && !in_array(strtolower($matrix[$heading][$i]), $headingData['allowed'])
                ) {
                    return [
                        false,
                        "Data integrity violation - Row ".($i+2)." , heading '$heading' must contain one of the following:",
                        $headingData['allowed']
                    ];
                }

                // convert values to correct state
                if ($headingData['type'] == 'int') {
                    $matrix[$heading][$i] = (int)$matrix[$heading][$i];
                } elseif ($heading == 'Used In Weldment') {
                    $matrix[$heading][$i] = (string)strtolower($matrix[$heading][$i]);
                } elseif ($heading == 'Process Type') {
                    $matrix[$heading][$i] = (string)strtoupper($matrix[$heading][$i]);
                }

            }

        }

        return [true, $matrix, ''];
    }
    
}