<?php
namespace Celo\GhostPDF\Compress;

use Celo\GhostPDF\Compress\AbstractCompress;
use Celo\GhostPDF\FileManager\File;

class MaxCompress extends AbstractCompress {
    /** @param File $file */
    function __construct(File $file){
        parent::__construct($file);
    }        

    protected function composeCommandArgs(string $output_path): string{
        return "-q -dNOPAUSE -dBATCH -dSAFER -dQUIET ".
            "-sDEVICE=pdfwrite  ".
            "-sstdout=%stderr ".
            "-dCompatibilityLevel=1.3  ".
            "-dEmbedAllFonts=true  ".
            "-dSubsetFonts=true  ".
            "-dDetectDuplicateImages=true ".
            "-dPDFSETTINGS=/screen  ".
            "-dDownsampleColorImages=true ".
            "-dDownsampleGrayImages=true ".
            "-dDownsampleMonoImages=true ".
            "-dColorImageResolution=72 ".
            "-dGrayImageResolution=72 ".
            "-dMonoImageResolution=72 ".
            "-dColorImageDownsampleThreshold=1.0 ".
            "-dGrayImageDownsampleThreshold=1.0 ".
            "-dMonoImageDownsampleThreshold=1.0 ".
            "-sOutputFile=$output_path ".$this->file->getPath();
    }
}