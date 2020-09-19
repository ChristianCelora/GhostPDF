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
$path_output_file = $gs->compress();
``` 

For max compression set first argument of compress function to *true*

## Author
Christian Celora.
Check my github at https://github.com/ChristianCelora