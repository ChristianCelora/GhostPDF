<?php
namespace Celo\GhostPDF\Security;

use Celo\GhostPDF\AbstractGS;
use Celo\GhostPDF\FileManager\File;

class SecurePDF extends AbstractGS{
    /** @var string $password */
    protected $password;
    /** @param File $file */
    function __construct(File $file){
        parent::__construct($file, "new");
        $this->password = "";
    } 
    /**
     * Sets password
     * @param string $psw
     */
    public function setPassword(string $psw){
        $this->password = $psw;
    }
    /**
     * Sets owner password to output pdf
     * @param $output_dir string    output directory
     * @param $output_name string   output filename
     * @param $extension string     output extension
     * @return string Output file path
     */
    public function secure(string $output_dir, string $output_name, string $extension): string{
        if($this->password == "")
            throw Exception("Password cannot be empty", 1);

        $output_path = $this->generateOutputFilePath($output_dir, $output_name, $extension);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }
    /**
     * Compose gs command args
     * @param string $output_path output file path
     * @return string args for the gs command
     */
    protected function composeCommandArgs(string $output_path): string{
        return "-sDEVICE=pdfwrite -dBATCH -dNOPROMPT -dNOPAUSE -dQUIET ".
            "-sOwnerPassword='$this->password' -sUserPassword='$this->password' -sOutputFile=$output_path ".$this->file->getPath();
    }
}