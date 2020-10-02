<?php
namespace Celo\GhostPDF\PagesManipulator;

use Celo\GhostPDF\FileManager\File;

/** Prototype */
class PagesManipulator {
    function __construct(File $file){
        $this->file = $file;
    } 
    /**
     * Remove pages from PDF
     * @param $output_dir string output directory
     * @param $output_name string output filename
     * @param $ranges array of ranges. Pages inside these ranges will be put in the output file
     * @return string Output filename
     */
    public function remove(string $output_dir, string $output_name, array $ranges): string{
        $output_path = $this->generateOutputFilePath($output_dir, $output_name);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path, $ranges));
        exec($command);
        return $output_path;
    }
    /**
     * Generate output file path
     * @param string $output_dir Specifies output directory.
     * @param string $output_name Specifies output file name.
     * @return string output file path
     */
    protected function generateOutputFilePath(string $output_dir, string $output_name): string{
        $filename = ($output_name != "") ? $output_name : $this->file->getFilename()."_new";
        $directory = ($output_dir != "") ? $output_dir : $this->file->getDirectory();
        return $directory."/".$filename.".pdf";
    }
    /**
     * Compose gs command args
     * @param string $output_path output file path
     * @param array $ranges     file page numbers to keep
     * @return string args for the gs command
     */
    private function composeCommandArgs(string $output_path, array $ranges){
        $ranges = $this->rangeAsString($ranges);
        return "-sDEVICE=pdfwrite -dNOPAUSE -dBATCH -dSAFER ". 
            "-sPageList=$ranges ". 
            "-sOutputFile=$output_path ".$this->file->getPath();
    }
    /**
     * Convert ranges array to string
     * @param array $ranges
     * @return string
     */
    private function rangeAsString(array $ranges){
        /**
         * $ranges -> array(
         *      0 => 1-1
         *      1 => 2-5
         * )
         */
        $range = array();
        foreach($ranges as $r){
            $r_arr = explode("-", $r);
            if(sizeof($r_arr) > 1){
                $range[] = ($r_arr[0] == $r_arr[1]) ? $r_arr[0] : $r;
            }
        }
        return implode(",", $range);
    }
}