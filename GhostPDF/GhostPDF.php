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

    public function compress(): string{
        $file_parts = pathinfo($this->path);
        $outputname = $this->generateOutputFilename();
        $command = $this->composeCommand($outputname);
        exec($command);
        return $this->dir."/".$outputname;
    }

    private function generateOutputFilename(): string{
        $file_parts = pathinfo($this->path);
        return $file_parts["filename"]."_compressed.pdf";
    }

    private function composeCommand(string $outputname): string{
        $output_path = $this->dir."/".$outputname;
        return "gs -q -dNOPAUSE -dBATCH -dSAFER ".
            "-sDEVICE=pdfwrite  ".
            "-dCompatibilityLevel=1.3  ".
            "-dPDFSETTINGS=/screen  ".
            "-dEmbedAllFonts=true  ".
            "-dSubsetFonts=true  ".
            "-dColorImageDownsampleType=/Bicubic  ".
            "-dColorImageResolution=144  ".
            "-dGrayImageDownsampleType=/Bicubic  ".
            "-dGrayImageResolution=144  ".
            "-dMonoImageDownsampleType=/Bicubic  ".
            "-dMonoImageResolution=144  ".
            "-sOutputFile=$output_path ".$this->path;
    }
}