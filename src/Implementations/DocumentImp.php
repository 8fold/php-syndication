<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Implementations;

trait DocumentImp
{
    private string $xmlVersion = '1.0';

    private string $xmlEncoding = '';

    private string|bool $xmlStandalone = '';

    public function xmlDeclaration(
        string|float|int $version = '1.0',
        string $encoding = 'UTF-8',
        bool $standalone = true
    ): self {
        $this->xmlVersion = $version;
        $this->xmlEncoding = $encoding;
        $this->xmlStandalone = $standalone;
        return $this;
    }
}
