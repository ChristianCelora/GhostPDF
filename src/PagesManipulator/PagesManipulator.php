<?php
namespace Celo\GhostPDF\PagesManipulator;

use Celo\GhostPDF\AbstractGS;
use Celo\GhostPDF\FileManager\File;

/** Prototype */
class PagesManipulator extends AbstractGS{
    /** @var array $ranges */
    private $ranges;
    /** @param File $file */
    function __construct(File $file){
        parent::__construct($file, "new");
        $this->ranges = array();
    }
    /**
     * Sets page ranges
     * @param array $r page ranges
     */
    public function setPageRanges(array $r){
        /**
         * $r -> array(
         *      0 => 1-1
         *      1 => 2-5
         * )
         */
        $this->ranges = $r;
    }
    /**
     * Remove pages from PDF
     * @param string $output_dir  Output directory
     * @param string $output_name Output filename
     * @param string $extension   Output file extension
     * @return string Output file path
     */
    public function remove(string $output_dir, string $output_name, string $extension): string{
        if(empty($this->ranges))
            throw Exception("Ranges cannot be empty", 1);
        $output_path = $this->generateOutputFilePath($output_dir, $output_name, $extension);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
    /**
     * Compose gs command args
     * @param string $output_path output file path
     * @return string args for the gs command
     */
    protected function composeCommandArgs(string $output_path): string{
        $ranges = $this->getRangeAsString();
        return "-sDEVICE=pdfwrite -dNOPAUSE -dBATCH -dSAFER ". 
            "-sPageList=$ranges ". 
            "-sOutputFile=$output_path ".$this->file->getPath();
    }
    /**
     * Convert ranges array to string
     * @return string
     */
    private function getRangeAsString(): string{
        $range = array();
        foreach($this->ranges as $r){
            $r_arr = explode("-", $r);
            if(sizeof($r_arr) > 1){
                $range[] = ($r_arr[0] == $r_arr[1]) ? $r_arr[0] : $r;
            }
        }
        return implode(",", $range);
    }
}