<?php
namespace Celo\GhostPDF\Compress;

use Celo\GhostPDF\AbstractGS;
use Celo\GhostPDF\FileManager\File;

/** Prototype */
abstract class AbstractCompress extends AbstractGS{
    /** @param File $file */
    function __construct(File $file){
        parent::__construct($file, "_compressed");
    }
    /**
     * Compress the PDF
     * @param string $output_dir  Output directory.
     * @param string $output_name Output file name.
     * @param string $extension   Output file extension.
     * @return string output file path
     */
    public function compress(string $output_dir, string $output_name, string $extension): string{
        $output_path = $this->generateOutputFilePath($output_dir, $output_name, $extension);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
}