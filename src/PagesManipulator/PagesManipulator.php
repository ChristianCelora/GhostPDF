<?php
namespace Celo\GhostPDF\PagesManipulator;

use Celo\GhostPDF\AbstractGS;
use Celo\GhostPDF\FileManager\File;

abstract class PagesManipulator extends AbstractGS{
    /** @var array $ranges */
    protected $ranges;
    /** 
     * @param File $file 
     * @param string $file_suffix 
     */
    function __construct(File $file, string $file_suffix = ""){
        parent::__construct($file, $file_suffix);
        $this->ranges = array();
    }
    /**
     * Sets page ranges
     * @param array $r page ranges
     */
    public function setPageRanges(array $r){
        /**
         * $r -> array(
         *      0 => 1-1
         *      1 => 2-5
         * )
         */
        $this->ranges = $r;
    }

    protected abstract function composeCommandArgs(string $output_path): string;
}