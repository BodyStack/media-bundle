<?php
declare(strict_types=1);

namespace Ranky\MediaBundle\Infrastructure\Filesystem\Local;

use Ranky\MediaBundle\Domain\Contract\FilePathResolverInterface;
use Ranky\MediaBundle\Domain\Enum\Breakpoint;

final class LocalFilePathResolver implements FilePathResolverInterface
{

    public function __construct(private readonly string $uploadDirectory)
    {

    }

    public function resolve(?string $path = null): string
    {
      $paths = [$this->uploadDirectory];
      if ($path) $paths[] = \trim($path,'/');
      return implode('/',$paths);
    }

    public function resolveFromBreakpoint(string $breakpoint, string $path = null): string
    {
        if (!Breakpoint::tryFrom($breakpoint)){
            throw new \InvalidArgumentException(\sprintf('%s is not a valid value for Breakpoint enum', $breakpoint));
        }

        $paths = [$this->uploadDirectory];
        $paths[] = 'styles';
        $paths[] = $breakpoint;
        if ($path) $paths[] = \trim($path,'/');
        return implode('/',$paths);
    }

    public function resolveFilePathFromBreakpoint(string $breakpoint, string $breakpointFilePath = null): string
    {
      if (!Breakpoint::tryFrom($breakpoint)){
        throw new \InvalidArgumentException(\sprintf('%s is not a valid value for Breakpoint enum', $breakpoint));
      }

      $path = $breakpointFilePath;
      $path = preg_replace('#^' .preg_quote($this->uploadDirectory,'#') . '#','',$path);
      $path = preg_replace('#^/?' .preg_quote('styles/'.$breakpoint,'#') . '#','',$path);
      return trim($path,'/');
    }
}
