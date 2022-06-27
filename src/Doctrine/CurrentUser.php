<?php
namespace App\Doctrine;


use App\Entity\Company;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;

class CurrentUser implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
    {        
        $this->addWhere($resourceClass, $queryBuilder);
    }

   public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?string $operationName = null, array $context = [])
   {
        $this->addWhere($resourceClass, $queryBuilder);
    }

   private function addWhere(string $resourceClass, $queryBuilder)
   {
    $user = $this->security->getUser();
    if ($resourceClass === Company::class){
        $alias = $queryBuilder->getRootAliases()[0];
        $queryBuilder
            ->andWhere("$alias.id = :current_user_company")
            ->setParameter('current_user_company', $user->getCompany()->getId());
    }
   }
}