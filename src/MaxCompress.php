<?php
namespace Celo\GhostPDF;

use Celo\GhostPDF\ICompress;
use Celo\GhostPDF\FileManager\File;

class MaxCompress extends ICompress {
    function __construct(File $file){
        $this->file = $file;
    }        

    protected function composeCommandArgs(string $outputname): string{
        $output_path = $this->file->getDirectory()."/".$outputname;
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
            "-sOutputFile=$outputname ".$this->file->getPath();
    }
}