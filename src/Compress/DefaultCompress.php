<?php
namespace Celo\GhostPDF\Compress;

use Celo\GhostPDF\Compress\ICompress;
use Celo\GhostPDF\FileManager\File;

class DefaultCompress extends ICompress {
    function __construct(File $file){
        $this->file = $file;
    }        

    protected function composeCommandArgs(string $output_path): string{
        return "-q -dNOPAUSE -dBATCH -dSAFER -dQUIET ".
            "-sDEVICE=pdfwrite  ".
            "-sstdout=%stderr ".
            "-dCompatibilityLevel=1.3  ".
            "-dEmbedAllFonts=true  ".
            "-dSubsetFonts=true  ".
            "-dDetectDuplicateImages=true ".
            "-dPDFSETTINGS=/ebook  ".
            "-dColorImageDownsampleType=/Bicubic  ".
            "-dColorImageResolution=144  ".
            "-dGrayImageDownsampleType=/Bicubic  ".
            "-dGrayImageResolution=144  ".
            "-dMonoImageDownsampleType=/Bicubic  ".
            "-dMonoImageResolution=144  ".
            "-sOutputFile=$output_path ".$this->file->getPath();
    }
}