<?php
namespace Celo\GhostPDF;

use Celo\GhostPDF\FileManager\File;

abstract class AbstractConverter {
    /** @var File $file */
    protected $file;
    /**
     * @param File $file
     */
    function __construct(File $file, string $file_suffix = ""){
        $this->file = $file;
    }
    /**
     * Generate input file path
     * @return string input file path
     */
    protected function getInputFilePath(): string{
        return $this->file->getPath();
    }
    /**
     * Get Output directory
    */
    protected function getOutputDirectory(string $output_dir){
        return ($output_dir != "") ? $output_dir : $this->file->getDirectory();
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