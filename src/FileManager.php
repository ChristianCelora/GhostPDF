<?php

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

class File {
    /** @var string $path */
    private $path;
    /** @var string $filename */
    private $filename;
    /** @var string $extension */
    private $extension;
    /** @var string $directory */
    private $directory;
    /**
     * @param string $path
     */
    function __construct(string $path){
        $path_parts = pathinfo($path);
        $this->path = $path;
        $this->directory = $path_parts["dirname"];
        $this->extension = $path_parts["extension"];
        $this->filename = $path_parts["filename"];
    }
    /**
     * Return File name without extension
     * @return string
     */
    public function getFilename(): string{
        return $this->filename;
    }
    /**
     * Return File extension
     * @return string
     */
    public function getExtension(): string{
        return $this->extension;
    }
    /**
     * Return File directory path
     * @return string
     */
    public function getDirectory(): string{
        return $this->directory;
    }
    /**
     * Return File path (directory + filename + extension)
     * @return string
     */
    public function getPath(): string{
        return $this->path;
    }
}