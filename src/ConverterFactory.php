<?php
namespace Celo\GhostPDF;

use Celo\GhostPDF\FileManager\FileManager;
use Celo\GhostPDF\Convert\IConverter;
use Celo\GhostPDF\Convert\PDFConverter;
use Celo\GhostPDF\Convert\DocxConverter;
use Exception;

class ConverterFactory {
    const PDF_CONVERTER = "pdf";
    const DOCX_CONVERTER = "docx";

    public static function create(string $path, string $converter_type, bool $flag_set_env = false): IConverter{
        $fm = new FileManager($path);
        if(!$fm->isFileValid()){
            throw new Exception("file path not valid: $path", 1);
        }
        $file = $fm->getFile();
        switch($converter_type){
            case self::PDF_CONVERTER:
                $converter = new PDFConverter($file, $flag_set_env);
                break;

            case self::DOCX_CONVERTER:
                $converter = new DocxConverter($file, $flag_set_env);
                break;
            
            default:
                throw new Exception("Converter type $converter_type not recognised", 2);
                break;

        }

        return $converter;
    }
}