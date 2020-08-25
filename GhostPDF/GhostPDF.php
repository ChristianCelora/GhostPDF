<?php

class GhostPDF {

    private $path;
    private $dir;
    private $original_name;

    function __construct(string $path){
        if(!$this->isPdfValid($path))
            throw new Exception("PDF path not valid: $path", 1);
        $file_parts = pathinfo($path);
        $this->path = $path;
        $this->dir = $file_parts["dirname"];
        $this->original_name = $file_parts["filename"];
    }

    private function isPdfValid(string $path): bool{
        $file_parts = pathinfo($path);
        return (file_exists($path) && is_file($path) && $file_parts["extension"] == "pdf");
    }

    public function compress(bool $max_compression = false): string{
        $file_parts = pathinfo($this->path);
        $outputname = $this->generateOutputFilename();
        $command = $this->composeCommand($outputname, $max_compression);
        exec($command);
        return $this->dir."/".$outputname;
    }

    private function generateOutputFilename(): string{
        $file_parts = pathinfo($this->path);
        return $file_parts["filename"]."_compressed.pdf";
    }
    // docs: https://www.ghostscript.com/doc/current/VectorDevices.htm
    private function composeCommand(string $outputname, bool $max_compression): string{
        $output_path = $this->dir."/".$outputname;
        $command = "gs -q -dNOPAUSE -dBATCH -dSAFER -dQUIET ".
            "-sDEVICE=pdfwrite  ".
            "-sstdout=%stderr ". // silence output messages
            "-dCompatibilityLevel=1.3  ".
              
            "-dEmbedAllFonts=true  ".
            "-dSubsetFonts=true  ".
            "-dDetectDuplicateImages=true ";
        if($max_compression){
            // screen = only screen, ebook = low, printer = high, prepress = high (preserving color), default = similar to screen
            $command .= "-dPDFSETTINGS=/screen  ".
                "-dDownsampleColorImages=true ".
                "-dDownsampleGrayImages=true ".
                "-dDownsampleMonoImages=true ".
                "-dColorImageResolution=72 ".
                "-dGrayImageResolution=72 ".
                "-dMonoImageResolution=72 ".
                "-dColorImageDownsampleThreshold=1.0 ".
                "-dGrayImageDownsampleThreshold=1.0 ".
                "-dMonoImageDownsampleThreshold=1.0 ";
        }else{
            $command .= "-dPDFSETTINGS=/ebook  ".
                "-dColorImageDownsampleType=/Bicubic  ".
                "-dColorImageResolution=144  ".
                "-dGrayImageDownsampleType=/Bicubic  ".
                "-dGrayImageResolution=144  ".
                "-dMonoImageDownsampleType=/Bicubic  ".
                "-dMonoImageResolution=144  ";
        }

        $command .= "-sOutputFile=$output_path ".$this->path;

        return $command;
    }
}