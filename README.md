# GhostPDF

Library for compress PDF file using ghostscript.

## Install
Install library through composer:
``` 
composer require celo/ghost-pdf
``` 

## Usage
Initialize
```
use Celo\GhostPDF\GhostPDF;

$gs = new GhostPDF($path);
```

Customize output file
```
$gs->setOutputDirectory($dir);
$gs->setOutputFilename($filename);
$gs->setOutputExtension($extension);
```
### Operations
Compress PDF
```
$path_output_file = $gs->compress();
$path_output_file = $gs->compress(true); // Max compression
```
Split PDF
```
$paths_output = $gs->split($page_ranges);
```
Remove pages PDF
```
$path_output_file = $gs->removePages($page_ranges);
```
Add password to open PDF
```
$path_output_file = $gs->secure($password);
```
Glue multiple PDFs
```
$path_output_file = $gs->join($paths);
``` 

## Convert files
Convert files to PDF 
```
    $converter = ConverterFactory::create($input_file, ConverterFactory::PDF_CONVERTER);
    $result_file = $converter->convert();
```


## Author
Christian Celora.
Check my github at https://github.com/ChristianCelora