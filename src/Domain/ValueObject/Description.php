<?php
declare(strict_types=1);

namespace Ranky\MediaBundle\Domain\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Embeddable]
final class Description
{

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private readonly string $alt;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private readonly string $title;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private readonly ?string $cite;

    public function __construct(string $alt, ?string $title = null, ?string $cite = '')
    {
        $this->alt = $alt;
        $this->title = $title ?? $alt;
        $this->cite = $cite??'';
    }

    public function alt(): string
    {
        return $this->alt;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function cite(): string
    {
      return $this->cite??'';
    }
}
