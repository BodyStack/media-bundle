<?php
declare(strict_types=1);

namespace Ranky\MediaBundle\Application\SafeFileName;

use Ranky\MediaBundle\Domain\Contract\MediaRepositoryInterface;
use Ranky\MediaBundle\Domain\Exception\NotFoundMediaException;
use Ranky\SharedBundle\Common\FileHelper;

class SafeFileName
{

    public function __construct(private readonly MediaRepositoryInterface $mediaRepository)
    {
    }

    public function __invoke(string $name, ?string $extension = null,?string $path = null): string
    {
        if ($extension === null) {
            $extension = (string)\pathinfo($name, \PATHINFO_EXTENSION);
        }
        $formatName = FileHelper::basename($name);
        $fullName   = \sprintf('%s.%s', $formatName, $extension);

        $attempts = 5;
        $unique = '';

        while($attempts) {
          try {
            if($path) {
              $this->mediaRepository->getByFilePath("$path/$fullName");
            }
            else $this->mediaRepository->getByFileName($fullName);
          }
          catch (NotFoundMediaException) {
            return $fullName;
          }

          $unique .= rand(0,9); // progressively make the unique key longer
          $fullName = \sprintf('%s_%d.%s', $formatName, $unique, $extension);
        }

        return \sprintf('%s_%d.%s', $formatName, \time(), $extension);  // fallback
    }
}
