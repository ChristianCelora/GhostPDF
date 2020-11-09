<?php
namespace Celo\GhostPDF\Convert;

use Celo\GhostPDF\AbstractConverter;
use Celo\GhostPDF\Convert\IConverter;
use Celo\GhostPDF\FileManager\File;

class DocxConverter extends AbstractConverter implements IConverter{
    
    function __construct(File $file){
        parent::__construct($file);
    } 

    public function convert(): string{
        $input_path = $this->getInputFilePath();
        $outputdir = $this->getOutputDirectory();
        $command = escapeshellcmd($this->soffice_path." --invisible --infilter='writer_pdf_import' ".
            " --convert-to docx:'MS Word 2007 XML' $input_path --outdir $outputdir");
        exec($command);
        return $this->generateOutputFilePath($outputdir, "", "docx");
    }
}