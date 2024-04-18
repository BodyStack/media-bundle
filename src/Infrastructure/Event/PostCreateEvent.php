<?php

declare(strict_types=1);

namespace Ranky\MediaBundle\Infrastructure\Event;


use Ranky\MediaBundle\Application\DataTransformer\Response\MediaResponse;
use Symfony\Contracts\EventDispatcher\Event;

class PostCreateEvent extends Event
{
    public const NAME = 'ranky.media.post_create';

    protected MediaResponse $mediaResponse;

    public function __construct(MediaResponse $mediaResponse)
    {
        $this->mediaResponse = $mediaResponse;
    }

    public function getMediaResponse(): MediaResponse
    {
        return $this->mediaResponse;
    }

    public function setMediaResponse(MediaResponse $mediaResponse)
    {
        $this->mediaResponse = $mediaResponse;
    }
}
