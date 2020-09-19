<?php
namespace Celo\GhostPDF\FileManager;

class FileManager {
    /** @var File $file */
    private $file;
    /**
     * @param string $path
     */
    function __construct(string $path){
        $this->file = new File($path);
    }
    /**
     * Sets new file
     * @param string $path
     */
    public function setFile(string $path){
        $this->file = new File($path);
    }
    /**
     * Checks if file is valid PDF
     * @return bool
     */
    public function isPdfValid(): bool{
        $path = $this->file->getPath();
        return (file_exists($path) && is_file($path) && $this->file->getExtension() == "pdf");
    }
    /**
     * Return file object
     * @return File
     */
    public function getFile(): File{
        return $this->file;
    }
}