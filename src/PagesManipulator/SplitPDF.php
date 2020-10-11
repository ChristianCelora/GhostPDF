<?php
namespace Celo\GhostPDF\PagesManipulator;

use Celo\GhostPDF\FileManager\File;

class SplitPDF extends PagesManipulator {
    function __construct(File $file){
        parent::__construct($file, "");
    }
    /**
     * Splits PDF into smaller pdf based on given ranges
     * @param string $output_dir  Output directory
     * @param string $output_name Output filename
     * @param string $extension   Output file extension
     * @return string[] Array of output file paths
     */
    public function split(string $output_dir, string $output_name, string $extension): array{
        if(empty($this->ranges))
            throw Exception("Ranges cannot be empty", 1);
        $paths = array();
        for($i = 0; $i < sizeof($this->ranges); $i++){
            $r = explode("-", $this->ranges[$i]);
            if(sizeof($r) > 1){
                $output_path = $this->generateOutputFilePath($output_dir, $output_name."_$i", $extension);
                $command =  escapeshellcmd("gs ".sprintf($this->composeCommandArgs($output_path), $r[0], $r[1]));
                exec($command);
                $paths[] = $output_path;
            }
        }
        return $paths;
    }
    /**
     * Compose gs command args
     * @param string $output_path output file path
     * @return string args for the gs command
     */
    protected function composeCommandArgs(string $output_path): string{
        return "-sDEVICE=pdfwrite -dNOPAUSE -dBATCH -dSAFER ". 
            "-dFirstPage=%d -dLastPage=%d ". 
            "-sOutputFile=$output_path ".$this->file->getPath();
    }
}