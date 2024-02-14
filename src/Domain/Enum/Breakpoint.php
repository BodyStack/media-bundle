<?php
declare(strict_types=1);

namespace Ranky\MediaBundle\Domain\Enum;

enum Breakpoint: string
{

    case XXLARGE = 'xxlarge';
    case XLARGE = 'xlarge';
    case LARGE = 'large';
    case MEDIUMPLUS = 'mediumplus';
    case MEDIUM = 'medium';
    case SMALL = 'small';
    case XSMALL = 'xsmall';

    /**
     * @return int[]
     */
    public function dimensions(): array
    {
        return match ($this) {
            self::XXLARGE => [1600],
            self::XLARGE => [1200],
            self::LARGE => [1024],
            self::MEDIUMPLUS => [800],
            self::MEDIUM => [768],
            self::SMALL => [576],
            self::XSMALL => [130, 130],
        };
    }

    /**
     * @return string[]
     */
    public static function breakpoints(): array
    {
        return \array_map(static fn(self $breakpoint) => $breakpoint->value, self::cases());
    }

}
