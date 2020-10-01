<?php
// require_once("CompressPrototype.php");

namespace Celo\GhostPDF;

use Celo\GhostPDF\FileManager\FileManager;
use Celo\GhostPDF\Factory\ComrpessFactory;

class GhostPDF {

    /** @var FileManager $fm */
    private $fm;
    /** @var ComrpessFactory $compress_factory */
    private $compress_factory;
    /** @var string $output_name */
    private $output_name;
    /** @var string $output_dir */
    private $output_dir;

    function __construct(string $path){
        $this->fm = new FileManager($path);
        if(!$this->fm->isFileValid()){
            throw new Exception("file path not valid: $path", 1);
        }
        $this->compress_factory = new ComrpessFactory();
        $this->output_name = "";
        $this->output_dir = "";
    }
    /**
     * Sets output file name
     * @param string $output_name
     */
    public function setOutputFilename(string $output_name){
        $this->output_name = $output_name;
    }
    /**
     * Sets output file directory
     * @param string $output_dir
     */
    public function setOutputDirectory(string $output_dir){
        $this->output_dir = $output_dir;
    }
    /**
     * Compress PDF 
     * @param bool $max_compression Optional. if true utilize maxium compression
     * @return string path compressed file 
     */
    public function compress(bool $max_compression = false): string{
        $type = ($max_compression) ? ComrpessFactory::MAX_COMPRESSION : ComrpessFactory::STANDARD_COMPRESSION;
        $engine = $this->compress_factory->create($type, $this->fm->getFile());
        return $engine->compress($this->output_dir, $this->output_name);
    }

}