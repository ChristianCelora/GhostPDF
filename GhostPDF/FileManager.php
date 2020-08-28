<?php

class FileManager {
    private $file;

    function __construct(string $path){
        $this->file = new File($path);
    }

    public function setFile(string $path){
        $this->file = $path;
    }

    public function isPdfValid(): bool{
        $path = $this->file->getPath();
        return (file_exists($path) && is_file($path) && $this->file->getExtension() == "pdf");
    }

    public function getFile(): File{
        return $this->file;
    }
}

class File {
    private $path;
    private $filename;
    private $extension;
    private $directory;

    function __construct(string $path){
        $path_parts = pathinfo(path);
        $this->path = $path;
        $this->directory = $path_parts["dirname"];
        $this->extension = $path_parts["extension"];
        $this->filename = $path_parts["filename"];
    }

    public function getFilename(): string{
        return $this->filename;
    }

    public function getExtension(): string{
        return $this->extension;
    }

    public function getDirectory(): string{
        return $this->directory;
    }

    public function getPath(): string{
        return $this->path;
    }
}