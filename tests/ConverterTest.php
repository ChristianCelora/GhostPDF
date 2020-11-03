<?php
require_once("vendor/autoload.php");

use \PHPUnit\Framework\TestCase;
use Celo\GhostPDF\ConverterFactory;
use Celo\GhostPDF\FileManager\File;

class ConverterTest extends TestCase {

    protected $filepath;
    /** @var array generated files during test */
    protected static $generated_files = array();

    protected function setUp(): void{
        global $argc, $argv;

        if($argc <= 2 || !isset($argv[2]))
            exit("Insert file path for unit test\n");

        $this->filepath = $argv[2];
        $file_parts = pathinfo($this->filepath);
    }

    public function testConvertFileToPdf(){
        $converter = ConverterFactory::create($this->filepath, ConverterFactory::PDF_CONVERTER);
        self::$generated_files[] = $converter->convert();
        $this->assertFileExists(end(self::$generated_files));
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals("pdf", $out_file_info["extension"]);
    }

    public function testConvertPdfToDocx(){
        // Takes file from previous test output (care if previous test fails)
        $converter = ConverterFactory::create(end(self::$generated_files), ConverterFactory::DOCX_CONVERTER);
        self::$generated_files[] = $converter->convert();
        $this->assertFileExists(end(self::$generated_files));
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals("docx", $out_file_info["extension"]);
    }

    public static function tearDownAfterClass(): void{
        /** Deletes all generated files */
        foreach(self::$generated_files as $path){
            unlink(__DIR__."/../".$path);
        }
    }
}