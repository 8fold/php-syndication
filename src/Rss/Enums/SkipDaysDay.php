<?php
declare(strict_types=1);

namespace Eightfold\Syndication\Rss\Enums;

enum SkipDaysDay: string
{
    case MONDAY = 'Monday';
    case TUESDAY = 'Tuesday';
    case WEDNESDAY = 'Wednesday';
    case THURSDAY = 'Thursday';
    case FRIDAY = 'Friday';
    case SATURDAY = 'Saturday';
    case SUNDAY = 'Sunday';
}
