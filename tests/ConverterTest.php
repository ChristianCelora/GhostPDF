<?php
require_once("vendor/autoload.php");

use \PHPUnit\Framework\TestCase;
use Celo\GhostPDF\ConverterFactory;
use Celo\GhostPDF\FileManager\File;

define("VALID_INPUT_EXTENSIONS", "docx,doc,xsl,xslx");

class ConverterTest extends TestCase {

    protected $filepath;
    /** @var array generated files during test */
    protected static $generated_files = array();

    protected function setUp(): void{
        global $argc, $argv;

        $this->filepath = end($argv);
        if(!file_exists($this->filepath)){
            exit("Insert valid file path for unit test\n");
        }
        $input_extension = pathinfo($this->filepath, PATHINFO_EXTENSION);
        if(!in_array($input_extension, explode(",", VALID_INPUT_EXTENSIONS))){
            exit("Insert file extension .$input_extension not valid\n");
        }
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

    public function testSetOutputDirectory(){
        $custom_out_dir = "/tmp";
        $converter = ConverterFactory::create($this->filepath, ConverterFactory::PDF_CONVERTER);
        $converter->setOutputDirectory($custom_out_dir);
        self::$generated_files[] = $converter->convert();
        $this->assertFileExists(end(self::$generated_files));
        $out_file_info = pathinfo(end(self::$generated_files));
        $this->assertEquals($custom_out_dir, $out_file_info["dirname"]);
    }

    public static function tearDownAfterClass(): void{
        /** Deletes all generated files */
        foreach(self::$generated_files as $path){
            if($path[0] == "/"){
                unlink($path);
            }else{
                unlink(__DIR__."/../".$path);
            }
        }
    }
}