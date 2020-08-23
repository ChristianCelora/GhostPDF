<?php
require_once(dirname(__FILE__)."/../GhostPDF/GhostPDF.php");

use \PHPUnit\Framework\TestCase;

class CoreTest extends TestCase {

    protected $gs_pdf;
    protected $filepath;
    protected $filename;

    protected function setUp(): void{
        global $argc, $argv;

        if($argc <= 2 || !isset($argv[2]))
            exit("Insert PDF path for unit test\n");

        $this->filepath = $argv[2];
        $file_parts = pathinfo($this->filepath);
        $this->filename = $file_parts["filename"];
        try{
            $this->gs_pdf = new GhostPDF($this->filepath);
        }catch(Exception $e){
            exit($e->getMessage());
        }
    }

    public function testCompress(){
        $outputfile = $this->gs_pdf->compress();
        $in_file_info = pathinfo($this->filepath);
        $out_file_info = pathinfo($outputfile);
        $this->assertEquals($in_file_info["filename"]."_compressed.pdf", 
            $out_file_info["filename"].".".$out_file_info["extension"]);
        $this->assertLessThanOrEqual(filesize($this->filepath), filesize($outputfile));
    }
}