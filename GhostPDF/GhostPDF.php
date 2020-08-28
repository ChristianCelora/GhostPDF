<?php

require_once("CompressPrototype.php");

class GhostPDF {

    /** @var FileManager $fm */
    private $fm;
    /** @var ComrpessFactory $compress_factory */
    private $compress_factory;

    function __construct(string $path){
        $fm = new FileManager($path);
        if(!$this->fm->isPdfValid()){
            throw new Exception("PDF path not valid: $path", 1);
        }
        $this->compress_factory = new ComrpessFactory();
    }

    public function compress(bool $max_compression = false): string{
        $type = ($max_compression) ? ComrpessFactory::MAX_COMPRESSION : ComrpessFactory::STANDARD_COMPRESSION;
        $engine = $this->compress_factory->create($this->fm->getFile());
    }
    
}