<?php
namespace Celo\GhostPDF;

use Celo\GhostPDF\FileManager\File;

abstract class AbstractGS {
    /** @var File $file */
    protected $file;
    /** @var string $output_file_suffix */
    protected $output_file_suffix;
    /**
     * @param File $file
     * @param string $file_suffix Output filename suffix (in case no output name is specified)
     */
    function __construct(File $file, string $file_suffix = ""){
        $this->file = $file;
        $this->output_file_suffix = $file_suffix;
    }
    /**
     * Generate output file path
     * @param string $output_dir Specifies output directory.
     * @param string $output_name Specifies output file name.
     * @return string output file path
     */
    protected function generateOutputFilePath(string $output_dir, string $output_name, string $extension): string{
        $filename = ($output_name != "") ? $output_name : $this->file->getFilename().$this->output_file_suffix;
        $directory = ($output_dir != "") ? $output_dir : $this->file->getDirectory();
        $extension = ($extension != "") ? $extension : "pdf";
        return $directory."/".$filename.".".$extension;
    }
    /**
     * Compose gs command args
     * @param string $output_path output file path
     * @return string args for the gs command
     */
    protected abstract function composeCommandArgs(string $output_path): string;
}