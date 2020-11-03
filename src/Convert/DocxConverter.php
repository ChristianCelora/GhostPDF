<?php
namespace Celo\GhostPDF\Convert;

use Celo\GhostPDF\AbstractConverter;
use Celo\GhostPDF\Convert\IConverter;
use Celo\GhostPDF\FileManager\File;

class DocxConverter extends AbstractConverter implements IConverter{

    function __construct(File $file){
        parent::__construct($file, "");
    } 

    public function convertFromPDF(): string{
        // 
    }

    public function convertToPDF(): string{
        $input_path = $this->getInputFilePath();
        $outputdir = $this->getOutputDirectory("");
        $command = escapeshellcmd("libreoffice --convert-to pdf:writer_pdf_Export $input_path --outdir $outputdir");
        exec($command);
        return $this->generateOutputFilePath($outputdir, "", "pdf");
    }
}