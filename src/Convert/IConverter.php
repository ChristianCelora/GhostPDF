<?php
namespace Celo\GhostPDF\Convert;

interface IConverter {
    public function convert(): string;
}