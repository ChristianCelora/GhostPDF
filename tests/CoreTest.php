<?php
require_once("vendor/autoload.php");

use \PHPUnit\Framework\TestCase;
use Celo\GhostPDF\GhostPDF;
use Celo\GhostPDF\FileManager\File;

class CoreTest extends TestCase {

    protected $gs_pdf;
    protected $filepath;
    protected $filename;
    /** @var array generated files during test */
    protected static $generated_files = array();

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
        self::$generated_files[] = $this->gs_pdf->compress();
        $in_file_info = pathinfo($this->filepath);
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals(
            $in_file_info["filename"]."_compressed.pdf", 
            $out_file_info["filename"].".".$out_file_info["extension"]
        );
        $this->assertLessThanOrEqual(
            filesize($this->filepath), 
            filesize(end(self::$generated_files)),
            "Compressed file should have smaller size than original :|"
        );
        $this->assertFileExists(end(self::$generated_files));
    }

    public function testMaxCompress(){
        self::$generated_files[] = $this->gs_pdf->compress(true);
        $in_file_info = pathinfo($this->filepath);
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals(
            $in_file_info["filename"]."_compressed.pdf", 
            $out_file_info["filename"].".".$out_file_info["extension"]
        );
        $this->assertLessThanOrEqual(
            filesize($this->filepath), 
            filesize(end(self::$generated_files)),
            "Compressed file should have smaller size than original :|"
        );
        $this->assertFileExists(end(self::$generated_files));
    }

    public function testSetOutputFilename(){
        $this->gs_pdf->setOutputFilename("test_renamed");
        self::$generated_files[] = $this->gs_pdf->compress();
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals("test_renamed", $out_file_info["filename"]);

    }

    public function testSetOutputDirectory(){
        $this->gs_pdf->setOutputDirectory("/tmp/");
        self::$generated_files[] = $this->gs_pdf->compress();
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals("/tmp", $out_file_info["dirname"]);
    }

    public function testKeepFirstPage(){
        self::$generated_files[] = $this->gs_pdf->removePages(["1-1"]);
        $this->assertFileExists(end(self::$generated_files));
        $this->assertEquals(
            1, 
            $this->count_pages(end(self::$generated_files)),
            "Il numero di pagine del file creato non corrispondono."
        );
    }

    public function testKeepFirstTenPages(){
        self::$generated_files[] = $this->gs_pdf->removePages(["1-10"]);
        $this->assertFileExists(end(self::$generated_files));
        $this->assertLessThanOrEqual(
            10, 
            $this->count_pages(end(self::$generated_files)),
            "Il numero di pagine del file creato non corrispondono."
        );
    }

    public function testSecurePages(){
        $outputfile = $this->gs_pdf->secure("1234");
        $this->assertFileExists($outputfile);
    }

    public function testJoinPdf(){
        self::$generated_files[] = $this->gs_pdf->join(array($this->filepath));
        $this->assertFileExists(end(self::$generated_files));
        $this->assertEquals(
            $this->count_pages(__DIR__."/../".$this->filepath) * 2, 
            $this->count_pages(end(self::$generated_files)),
            "Il numero di pagine del file creato non corrispondono."
        );
    }

    public function testSplitPdf(){
        $ranges = array("1-2", "3-4", "5-6");
        $files = $this->gs_pdf->split($ranges);
        foreach($files as $outputfile){
            self::$generated_files[] = $outputfile;
            $this->assertFileExists($outputfile);
            $this->assertEquals(
                2, 
                $this->count_pages($outputfile),
                "Il numero di pagine del file creato non corrispondono."
            );
        }
    }

    public function testConvertFileToPdf(){
        $converter = ConverterFactory::create($this->filepath, ConverterFactory::PDF_CONVERTER);
    }

    /** Auxiliar functions */
    private function count_pages($pdfname) {
        $pdftext = file_get_contents($pdfname);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }

    public static function tearDownAfterClass(): void{
        /** Deletes all generated files */
        foreach(self::$generated_files as $path){
            unlink(__DIR__."/../".$path);
        }
    }
}