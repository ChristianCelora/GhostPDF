<?php
namespace Celo\GhostPDF\Factory;

use Celo\GhostPDF\ICompress;
use Celo\GhostPDF\DefaultCompress;
use Celo\GhostPDF\MaxCompress;
use Celo\GhostPDF\FileManager\File;

/** Factory */
class ComrpessFactory {
    const STANDARD_COMPRESSION = 0;
    const MAX_COMPRESSION = 1;

    function __construct(){}
    /**
     * Creates new compress object based on $compression_type
     * @param int $compression_type Indicate the type of compression
     * @param File $file
     */
    public function create(int $compression_type, File $file): ICompress{
        switch($compression_type){
            case self::STANDARD_COMPRESSION:
                return new DefaultCompress($file);
            case self::MAX_COMPRESSION:
                return new MaxCompress($file);
        }
    }
}