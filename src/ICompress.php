<?php
namespace Celo\GhostPDF;

/** Prototype */
abstract class ICompress {
    /** @var Celo\GhostPDF\FileManager\File $file */
    protected $file;
    /**
     * Compose gs command args
     * @param string $outputname outptu file name
     * @return string args for the gs command
     */
    protected abstract function composeCommandArgs(string $outputname): string;
    /**
     * Generate output file path
     * @param string $output_name Specifies output file name.
     * @return string output file path
     */
    protected function generateOutputFilePath(string $output_name): string{
        $filename = ($output_name != "") ? $output_name : $this->file->getFilename()."_compressed";
        return $this->file->getDirectory()."/".$filename.".pdf";
    }
    /**
     * Compress the PDF
     * @param string $output_name Optional. Specifies output file name.
     * @return string output file path
     */
    public function compress(string $output_name = ""): string{
        $output_path = $this->generateOutputFilePath($output_name);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
}