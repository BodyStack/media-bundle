<?php

declare(strict_types=1);

namespace Ranky\MediaBundle\Application\FileManipulation\Thumbnails\GenerateThumbnails;

use Intervention\Image\ImageManager;
use Ranky\MediaBundle\Domain\Contract\FilePathResolverInterface;
use Ranky\MediaBundle\Domain\Contract\FileRepositoryInterface;
use Ranky\MediaBundle\Domain\Contract\FileUrlResolverInterface;
use Ranky\MediaBundle\Domain\Contract\MediaRepositoryInterface;
use Ranky\MediaBundle\Domain\Enum\ImageResizeDriver;
use Ranky\MediaBundle\Domain\Service\FileResizeHandler;
use Ranky\MediaBundle\Domain\ValueObject\Dimension;
use Ranky\MediaBundle\Domain\ValueObject\File;
use Ranky\MediaBundle\Domain\ValueObject\MediaId;
use Ranky\MediaBundle\Domain\ValueObject\Thumbnail;
use Ranky\MediaBundle\Domain\ValueObject\Thumbnails;

abstract class AbstractGenerateImageThumbnails
{

    /**
     * @param int|null $originalMaxWidth
     * @param array<string, mixed> $breakpoints
     * @param FileResizeHandler $fileResizeHandler
     * @param MediaRepositoryInterface $mediaRepository
     * @param FileRepositoryInterface $fileRepository
     * @param FilePathResolverInterface $filePathResolver
     * @param FileUrlResolverInterface $fileUrlResolver
     */
    public function __construct(
        protected readonly ?int $originalMaxWidth,
        protected readonly ?int $originalMaxHeight,
        protected readonly array $breakpoints,
        protected readonly FileResizeHandler $fileResizeHandler,
        protected readonly MediaRepositoryInterface $mediaRepository,
        protected readonly FileRepositoryInterface $fileRepository,
        protected readonly FilePathResolverInterface $filePathResolver,
        protected readonly FileUrlResolverInterface $fileUrlResolver
    ) {
    }

    public function generate(string $mediaId): void
    {
        $media         = $this->mediaRepository->getById(MediaId::fromString($mediaId));
        $file          = $media->file();
        $fileDimension = $media->dimension();

        if(!$this->fileResizeHandler->support($file)) {
             return;
        }

        // Re-orient the file so that the proper width and height dimensions are determined
        if($results = $this->reorientOriginalFile($file)) {
          [$file, $fileDimension] = $results;
          $media->updateFileDimension($file, $fileDimension);
        }

        // resize original if the image is too large in a given dimension
        if (\is_int($this->originalMaxWidth) || \is_int($this->originalMaxHeight)) {
            [$file, $fileDimension] = $this->resizeOriginalFile($file, $fileDimension);
            $media->updateFileDimension($file, $fileDimension);
        }

        // generate thumbnails
        $media->addThumbnails($this->makeThumbnails($fileDimension, $file));
        $this->mediaRepository->save($media);
    }

    protected function reorientOriginalFile(File $file): ?array {
      $filepath = $this->filePathResolver->resolve($file->path());

      // Hack: only works for ImageMagic resize_driver
      $manager   = new ImageManager(['driver' => ImageResizeDriver::IMAGICK->value]);
      $image     = $manager->make($filepath);
      if ($image->exif('Orientation')<=1) return null;

      $image->orientate();
      $image->save($filepath);

      $file          = $file->updateSize($image->filesize());
      $fileDimension = new Dimension($image->width(),$image->height());

      return [$file,$fileDimension];
    }

    /**
     * @param \Ranky\MediaBundle\Domain\ValueObject\File $file
     * @param \Ranky\MediaBundle\Domain\ValueObject\Dimension $fileDimension
     *
     * @return array{File, Dimension}
     */
    protected function resizeOriginalFile(File $file, Dimension $fileDimension): array
    {
      // Resize only along the larger dimension
      $scaleX = $this->originalMaxWidth ? $fileDimension->width() / $this->originalMaxWidth : 1;
      $scaleY = $this->originalMaxHeight ? $fileDimension->height() / $this->originalMaxHeight : 1;

        if ($scaleX>1 || $scaleY>1) {
          if ($scaleX > $scaleY) $newDimension = new Dimension($this->originalMaxWidth,null);
          else $newDimension = new Dimension(null,$this->originalMaxHeight);

            $outputPath = $this->filePathResolver->resolve($file->path());
            if (!$this->fileResizeHandler->resize(
                $file,
                $outputPath,
                $outputPath,
                $newDimension,
            )) {
                return [$file, $fileDimension];
            }
            $file          = $file->updateSize($this->fileRepository->filesizeFromPath($outputPath));
            $fileDimension = $this->fileRepository->dimensionsFromPath($outputPath);
        }

        return [$file, $fileDimension];
    }


    protected function makeThumbnails(Dimension $fileDimension, File $file): Thumbnails
    {
        $filePath   = $this->filePathResolver->resolve($file->path());
        $thumbnails = new Thumbnails();
        foreach ($this->breakpoints as $nameBreakpoint => $dimensionBreakpoint) {
            if (!$dimensionBreakpoint) continue;
            if ($dimensionBreakpoint[0] && $dimensionBreakpoint[0] > $fileDimension->width()) {
                continue;
            }

            $outputPath = $this->filePathResolver->resolveFromBreakpoint($nameBreakpoint, $file->path());
            $this->fileRepository->makeDirectory($outputPath);

            if (!$this->fileResizeHandler->resize(
                $file,
                $filePath,
                $outputPath,
                Dimension::fromArray($dimensionBreakpoint)
            )){
                continue;
            }

            $thumbnailUrlPath = $this->fileUrlResolver->resolvePathFromBreakpoint($nameBreakpoint, $file->path());
            $thumbnails->add(
                new Thumbnail(
                    $nameBreakpoint,
                    $file->name(),
                    $thumbnailUrlPath,
                    $this->fileRepository->filesizeFromPath($outputPath),
                    $this->fileRepository->dimensionsFromPath($outputPath, $file->mime())
                )
            );
        }

        return $thumbnails;
    }
}
