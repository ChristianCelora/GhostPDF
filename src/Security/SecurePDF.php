<?php
namespace Celo\GhostPDF\Security;

use Celo\GhostPDF\FileManager\File;

class SecurePDF {
    function __construct(File $file){
        $this->file = $file;
    } 
    /**
     * Sets owner password to output pdf
     * @param $output_dir string    output directory
     * @param $output_name string   output filename
     * @param string $psw           password
     * @return string Output filename
     */
    public function secure(string $output_dir, string $output_name, string $psw){
        $output_path = $this->generateOutputFilePath($output_dir, $output_name);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path, $psw));
        exec($command);
        return $output_path;
    }
    /**
     * Generate output file path
     * @param string $output_dir    Specifies output directory.
     * @param string $output_name   Specifies output file name.
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
     * @param string $psw           password
     * @return string args for the gs command
     */
    protected function composeCommandArgs(string $output_path, string $psw): string{
        return "gs -sDEVICE=pdfwrite -dBATCH -dNOPROMPT -dNOPAUSE -dQUIET ".
            "-sOwnerPassword=$psw -sOutputFile=$output_path ".$this->file->getPath();
    }
}