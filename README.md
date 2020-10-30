# GhostPDF

Library for compress PDF file using ghostscript.

## Install
Install library through composer:
``` 
composer require celo/ghost-pdf
``` 

## Usage
``` 
use Celo\GhostPDF\GhostPDF;

$gs = new GhostPDF($path);
// Customize output file
$gs->setOutputDirectory($dir);
$gs->setOutputFilename($filename);
$gs->setOutputExtension($extension);
// Operations
// Compress PDF
$path_output_file = $gs->compress();
$path_output_file = $gs->compress(true); // Max compression
// Split PDF
$paths_output = $gs->split($page_ranges);
// Remove pages PDF
$path_output_file = $gs->removePages($page_ranges);
// Add password to open PDF
$path_output_file = $gs->secure($password);
// Glue multiple PDFs
$path_output_file = $gs->join($paths);
``` 

For max compression set first argument of compress function to *true*

## Author
Christian Celora.
Check my github at https://github.com/ChristianCelora