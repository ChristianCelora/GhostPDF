<?php
namespace Celo\GhostPDF\PagesManipulator;

/** Prototype */
class PagesManipulator {
    public function remove(string $output_dir = "", string $output_name = ""): string{
        $output_path = $this->generateOutputFilePath($output_dir, $output_name);
        $command = escapeshellcmd("gs ".$this->composeCommandArgs($output_path));
        exec($command);
        return $output_path;
    }

    private function composeCommandArgs(){

    }
}