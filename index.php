<?php
require_once("GhostPDF/GhostPDF.php");

if($argc < 2 || !isset($argv[1]))
    exit("Insert PDF path for unit test\n");

$filepath = $argv[1];
main($filepath);


function main(string $input_file){
    $original_size = filesize($input_file);
    try{
    $gs_pdf = new GhostPDF($input_file);
    }catch(Exception $e){
        exit($e->getMessage());
    }
    $result_file = $gs_pdf->compress();
    $compressed_size = filesize($result_file);
    
    echo "File compressed succesfully!\n".
        "compressed file: $result_file \n".
        "original size: ".formatSizeUnits($original_size)."\n".
        "compressed size: ".formatSizeUnits($compressed_size)."\n";
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
