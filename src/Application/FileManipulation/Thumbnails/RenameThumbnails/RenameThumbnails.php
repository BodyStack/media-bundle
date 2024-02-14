<?php
declare(strict_types=1);

namespace Ranky\MediaBundle\Application\FileManipulation\Thumbnails\RenameThumbnails;

use Ranky\MediaBundle\Domain\Contract\FilePathResolverInterface;
use Ranky\MediaBundle\Domain\Contract\FileRepositoryInterface;
use Ranky\MediaBundle\Domain\Contract\FileUrlResolverInterface;
use Ranky\MediaBundle\Domain\ValueObject\Thumbnail;
use Ranky\MediaBundle\Domain\ValueObject\Thumbnails;

class RenameThumbnails
{

    public function __construct(
        private readonly FileRepositoryInterface $fileRepository,
        private readonly FileUrlResolverInterface $fileUrlResolver,
        private readonly FilePathResolverInterface $filePathResolver,
    ) {
    }

    public function __invoke(Thumbnails $thumbnails, string $newFileName): Thumbnails
    {
        $newThumbnails = new Thumbnails();
        /* @var Thumbnail $thumbnail */
        foreach ($thumbnails as $thumbnail) {
            $filepath = $this->filePathResolver->resolveFilePathFromBreakpoint($thumbnail->breakpoint(),$thumbnail->path());
            $path = \pathinfo($filepath,PATHINFO_DIRNAME);
            $oldPath = $this->filePathResolver->resolve($thumbnail->path());
            $newPath = $this->filePathResolver->resolveFromBreakpoint($thumbnail->breakpoint(), "$path/" . $newFileName);
            $this->fileRepository->rename($oldPath, $newPath);

            $thumbnailPath = $this->fileUrlResolver->resolvePathFromBreakpoint($thumbnail->breakpoint(), "$path/" . $newFileName);
            $newThumbnails->add($thumbnail->rename($newFileName, $thumbnailPath));
        }

        return $newThumbnails;
    }

}
