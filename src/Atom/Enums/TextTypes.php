<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Atom\Enums;

enum TextTypes: string
{
    case TEXT = 'text';
    case HTML = 'html';
    case XHTML = 'xhtml';
}
