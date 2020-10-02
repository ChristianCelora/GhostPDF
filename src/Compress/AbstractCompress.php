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
     * @param string $output_dir Optional. Specifies output directory.
     * @param string $output_name Optional. Specifies output file name.
     * @return string output file path
     */
    public function compress(string $output_dir = "", string $output_name = ""): string{
        $output_path = $this->generateOutputFilePath($output_dir, $output_name);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
}