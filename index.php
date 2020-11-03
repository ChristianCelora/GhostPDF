<?php
/**
 * Command inline arguments
 *  1- path: file to compress
 *  2- max_compression: if set use max compression
 */

require_once("vendor/autoload.php");

use Celo\GhostPDF\GhostPDF;
use Celo\GhostPDF\ConverterFactory;

if($argc < 2 || !isset($argv[1]))
    exit("Insert PDF path for unit test\n");

$filepath = $argv[1];
$max_compression = (isset($argv[2]));
main($filepath, $max_compression);


function main(string $input_file, bool $max_compression){
    $original_size = filesize($input_file);
    try{
        $gs = new GhostPDF($input_file);
    }catch(Exception $e){
        exit($e->getMessage());
    }
    // echo "Compressing...\n";
    // $result_file = $gs->compress($max_compression);
    // $compressed_size = filesize($result_file);
    // echo "File compressed succesfully!\n".
    //     "compressed file: $result_file \n".
    //     "original size: ".formatSizeUnits($original_size)."\n".
    //     "compressed size: ".formatSizeUnits($compressed_size)."\n";

    // $result_file = $gs->secure("aaa");

    // Convert
    $converter = ConverterFactory::create($input_file, ConverterFactory::PDF_CONVERTER);
    $result_file = $converter->convert();
    print("Converting...\n");
    print("Converted! result file $result_file\n");
}

function formatSizeUnits($bytes){
    if ($bytes >= 1073741824){
        $bytes = number_format($bytes / 1073741824, 2)." GB";
    }elseif ($bytes >= 1048576){
        $bytes = number_format($bytes / 1048576, 2)." MB";
    }elseif ($bytes >= 1024){
        $bytes = number_format($bytes / 1024, 2)." KB";
    }elseif ($bytes > 1){
        $bytes = $bytes." bytes";
    }elseif ($bytes == 1){
        $bytes = $bytes." byte";
    }else{
        $bytes = "0 bytes";
    }

    return $bytes;
}
