<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom\Enums;

enum LinkRel: string
{
    case ALTERNATE = 'alternate';
    case ENCLOSURE = 'enclosure';
    case RELATED = 'related';
    case SELF = 'self';
    case VIA = 'via';
}
