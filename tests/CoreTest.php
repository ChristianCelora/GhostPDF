<?php
require_once("vendor/autoload.php");

use \PHPUnit\Framework\TestCase;
use Celo\GhostPDF\GhostPDF;

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

    public function testDefaultCompress(){
        $outputfile = $this->gs_pdf->compress();
        $in_file_info = pathinfo($this->filepath);
        $out_file_info = pathinfo($outputfile);
        $this->assertEquals(
            $in_file_info["filename"]."_compressed.pdf", 
            $out_file_info["filename"].".".$out_file_info["extension"]
        );
        $this->assertLessThanOrEqual(
            filesize($this->filepath), 
            filesize($outputfile),
            "Compressed file should have smaller size than original :|"
        );
    }

    public function testMaxCompress(){
        $outputfile = $this->gs_pdf->compress(true);
        $in_file_info = pathinfo($this->filepath);
        $out_file_info = pathinfo($outputfile);
        $this->assertEquals(
            $in_file_info["filename"]."_compressed.pdf", 
            $out_file_info["filename"].".".$out_file_info["extension"]
        );
        $this->assertLessThanOrEqual(
            filesize($this->filepath), 
            filesize($outputfile),
            "Compressed file should have smaller size than original :|"
        );
    }

    public function testSetOutputFilename(){
        $this->gs_pdf->setOutputFilename("test_renamed");
        $outputfile = $this->gs_pdf->compress();
        $out_file_info = pathinfo($outputfile);
        $this->assertEquals("test_renamed", $out_file_info["filename"]);

    }
}