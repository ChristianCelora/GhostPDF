<?php
require_once("FileManager.php");

/** Factory */
class ComrpessFactory {
    const STANDARD_COMPRESSION = 0;
    const MAX_COMPRESSION = 1;

    function __construct(){}

    public function create(int $compression_type, File $file): ICompress{
        switch($compression_type){
            case self::STANDARD_COMPRESSION:
                return new DefaultCompress($file);
            case self::MAX_COMPRESSION:
                return new MaxCompress($file);
        }
    }
}

/** Prototype */
abstract class ICompress {
    protected $file;

    protected abstract function composeCommandArgs(string $outputname);
    protected abstract function generateOutputFilePath();

    public function compress() : string{
        $output_path = $this->generateOutputFilePath();
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
}

class DefaultCompress extends ICompress {
    function __construct(File $file){
        $this->file = $file;
    }        

    protected function composeCommandArgs(string $outputname){
        $output_path = $this->file->getDirectory()."/".$outputname;
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
            "-sOutputFile=$outputname ".$this->file->getPath();
    }

    protected function generateOutputFilePath(){
        return $this->file->getDirectory()."/".$this->file->getFilename()."_compressed.pdf";
    }
}

class MaxCompress extends ICompress {
    function __construct(File $file){
        $this->file = $file;
    }        

    protected function composeCommandArgs(string $outputname){
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

    protected function generateOutputFilePath(){
        return $this->file->getDirectory()."/".$this->file->getFilename()."_compressed.pdf";
    }
}