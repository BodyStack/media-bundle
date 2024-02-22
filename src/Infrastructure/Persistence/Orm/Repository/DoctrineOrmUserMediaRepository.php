<?php
declare(strict_types=1);

namespace Ranky\MediaBundle\Infrastructure\Persistence\Orm\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Ranky\MediaBundle\Domain\Contract\UserMediaRepositoryInterface;
use Ranky\MediaBundle\Domain\Model\Media;
use Ranky\SharedBundle\Domain\ValueObject\UserIdentifier;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<\Symfony\Component\Security\Core\User\UserInterface>
 */
final class DoctrineOrmUserMediaRepository extends ServiceEntityRepository implements UserMediaRepositoryInterface
{

    public function __construct(
        ManagerRegistry $registry,
        private readonly ?string $userEntity,
        private readonly string $userIdentifierProperty,
        private readonly string $userNameProperty
    ) {
        parent::__construct($registry, Media::class);
    }


    public function getAll(): array
    {
        return $this
            ->createQueryBuilder('m')
            ->select('m.createdBy as username', sprintf('count(%s) as count', 'm'))
            ->groupBy('m.createdBy')
            ->getQuery()
            ->getResult();
    }

    public function getUsernameByUserIdentifier(UserIdentifier $userIdentifier): string
    {
        if ($this->userIdentifierProperty === $this->userNameProperty) {
            return $userIdentifier->value();
        }
        if (!$this->userEntity){
            return UserIdentifier::DEFAULT_USER_IDENTIFIER;
        }
        try {
            return $this->_em->createQueryBuilder()
                ->from($this->userEntity, 'u')
                ->select("u.$this->userNameProperty")
                ->where(sprintf('u.%s = :identifier', $this->userIdentifierProperty))
                ->setParameter('identifier', $userIdentifier->value())
                ->getQuery()
                ->getSingleResult()[$this->userNameProperty];
        } catch (\Throwable) {
            // TODO
            return UserIdentifier::DEFAULT_USER_IDENTIFIER;
        }
    }

    public function getUserIdentifierFromUser(?UserInterface $user): ?string {
      if(!$user) return null;
      else {
        $getter = "get" . str_replace('_','',ucwords($this->userIdentifierProperty));
        return (string)($user->$getter());
      }
    }
}
