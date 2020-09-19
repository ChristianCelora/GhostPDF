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
     * @return string output file path
     */
    protected abstract function generateOutputFilePath(): string;
    /**
     * Compress the PDF
     * @return string output file path
     */
    public function compress(): string{
        $output_path = $this->generateOutputFilePath();
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
}