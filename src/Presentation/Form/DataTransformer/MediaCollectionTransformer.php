<?php

declare(strict_types=1);


namespace Ranky\MediaBundle\Presentation\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ranky\MediaBundle\Domain\Contract\MediaRepositoryInterface;
use Ranky\MediaBundle\Domain\Model\Media;
use Ranky\MediaBundle\Domain\ValueObject\MediaId;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class MediaCollectionTransformer implements DataTransformerInterface
{
    public function __construct(private readonly MediaRepositoryInterface $mediaRepository)
    {
    }

    /**
     * @throws \JsonException
     */
    public function transform(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!$value instanceof Collection) {
            throw new TransformationFailedException(
                \sprintf(
                    'Expected a Doctrine Collection instance. %s type given',
                    gettype($value)
                )
            );
        }

        if ($value->isEmpty()) {
            return \json_encode([], JSON_THROW_ON_ERROR);
        }
        $collection = $value->toArray();
        $arrayIds   = array_map(static fn(Media $media) => $media->id()->asString(), $collection);

        return \json_encode($arrayIds, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws \JsonException
     */
    public function reverseTransform(mixed $value): ?Collection
    {
        if (null === $value || '' === $value) {
            return new ArrayCollection();
        }

        if (!\is_string($value)) {
            throw new TransformationFailedException(\sprintf('Expected a json string. %s type given', gettype($value)));
        }

        $ids             = \json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        $medias          = $this->mediaRepository->findByIds(
            ...array_map(static fn(string $id) => MediaId::fromString($id), $ids)
        );

        // Ensure the order of the medias is the same as the order of the ids
        $medias = array_combine(
          array_map(fn(Media $media) => $media->id()->asString(), $medias),
          $medias
        );

        $arrayCollection = new ArrayCollection();
        foreach ($ids as $id) {
          if (isset($medias[$id])) {
            $arrayCollection->add($medias[$id]);
          }
        }
        return $arrayCollection;
    }
}
