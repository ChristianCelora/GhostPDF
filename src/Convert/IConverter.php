<?php
namespace Celo\GhostPDF\Convert;

interface IConverter {

    public function convertFromPDF(): string;

    public function convertToPDF(): string;
}