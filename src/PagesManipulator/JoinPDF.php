<?php
namespace Celo\GhostPDF\PagesManipulator;

use Celo\GhostPDF\AbstractGS;
use Celo\GhostPDF\FileManager\File;

class JoinPDF extends AbstractGS{
    /** @var File[] $files */
    private $files;
    /**
     * @param File[] $files Array of FileManager objects
     */
    function __construct(array $files){
        if(empty($files)){
            throw new Exception("files cannot be empty!");
        }
        parent::__construct($files[0], "join");
        $this->resetFiles();
        $this->addFiles($files);
    }
    /**
     * @param File[] $files Array of FileManager objects
     */
    public function addFiles(array $files){
        foreach($files as $file){
            $this->files[] = $file;
        }
    }
    /**
     * Resets files array
     */
    public function resetFiles(){
        $this->files = array();
    }
    /**
     * Join pdfs
     * @param string $output_dir  Output directory.
     * @param string $output_name Output file name.
     * @param string $extension   Output file extension.
     * @return string output file path
     */
    public function join(string $output_dir, string $output_name, string $extension): string{
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
        return "-q -dNOPAUSE -dBATCH -dSAFER -dQUIET -sDEVICE=pdfwrite ".
            "-sOutputFile=$output_path ".implode(" ", $this->getFilesPath());
    }
    /**
     * @return array Array of paths
     */
    private function getFilesPath(): array{
        $paths = array();
        foreach($this->files as $file){
            $paths[] = $file->getPath();
        }
        return $paths;
    }
}