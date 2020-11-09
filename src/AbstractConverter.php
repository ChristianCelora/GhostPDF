<?php
namespace Celo\GhostPDF;

use Celo\GhostPDF\FileManager\File;

abstract class AbstractConverter {
    /** @var File $file */
    protected $file;
    /** @var string $output_dir */
    protected $output_dir;
    /** @var string $soffice_path */
    protected $soffice_path;
    /**
     * @param File $file
     * @param boolean $flag_www_data If flag is true environment is set for exec libreoffice command (recommended if user is www-data)
     */
    function __construct(File $file, bool $flag_www_data = false){
        $this->file = $file;
        $this->output_dir = "";
        if($flag_www_data){
            putenv('PATH=/usr/local/bin:/bin:/usr/bin:/usr/local/sbin:/usr/sbin:/sbin');
            putenv('HOME=/tmp'); 
        }
        $this->soffice_path = $this->detectLibreofficeDirectory();
    }
    /**
     * Detects installation of soffice/libreoffice
     * @throws Exception if soffice not found on system
     * @return string soffice absolute path
     */
    private function detectLibreofficeDirectory(){
        exec("which soffice", $res);
        if(empty($res) && !isset($res[0])){
            throw new Exception("could not find soffice/libreoffice installation");
        }
        return $res[0];
    }
    /**
     * Generate input file path
     * @return string input file path
     */
    protected function getInputFilePath(): string{
        return $this->file->getPath();
    }
    /**
     * Sets custom output directory
     * @param string $output_dir
     */
    public function setOutputDirectory(string $output_dir){
        $this->output_dir = $output_dir;
    }
    /**
     * Get Output directory
     * @return string output directory
    */
    protected function getOutputDirectory(): string{
        return ($this->output_dir != "") ? $this->output_dir : $this->file->getDirectory();
    }
    /**
     * Generate output file path
     * @param string $output_dir Specifies output directory.
     * @param string $output_name Specifies output file name.
     * @return string output file path
     */
    protected function generateOutputFilePath(string $output_dir, string $output_name, string $extension): string{
        $filename = ($output_name != "") ? $output_name : $this->file->getFilename();
        $directory = ($output_dir != "") ? $output_dir : $this->file->getDirectory();
        $extension = ($extension != "") ? $extension : $this->file->getExtension();
        return $directory."/".$filename.".".$extension;
    }
}