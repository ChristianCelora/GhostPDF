<?php
namespace Celo\GhostPDF;

use Celo\GhostPDF\FileManager\FileManager;
use Celo\GhostPDF\Convert\IConverter;
use Celo\GhostPDF\Convert\PDFConverter;
use Exception;

class ConverterFactory {
    const PDF_CONVERTER = "pdf";

    public static function create(string $path, string $converter_type): IConverter{
        $fm = new FileManager($path);
        if(!$fm->isFileValid()){
            throw new Exception("file path not valid: $path", 1);
        }
        $file = $fm->getFile();
        switch($converter_type){
            case "pdf":
                $converter = new PDFConverter($file);
                break;
            
            default:
                throw new Exception("Converter type $converter_type not recognised", 2);
                break;

        }

        return $converter;
    }
}