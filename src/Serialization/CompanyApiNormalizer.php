<?php

namespace App\Serialization;

use App\Entity\Company;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CompanyApiNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_NORMALIZER = 'NormalizerAlreadyCalled';
    private $authorizationChecker;
    
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = [])
    { 
        $alreadyCalled = $context[self::ALREADY_NORMALIZER] ?? false;
        return $data instanceof Company && $alreadyCalled === false;
    }

    public function normalize($object, ?string $format = null, array $context = [])
    {
        $context[self::ALREADY_NORMALIZER] = true;
        if($this->authorizationChecker->isGranted('ROLE_USER_ONE') && isset($context['groups'])){
            $context['groups'][] = 'Limit:one';
        }
        return $this->normalizer->normalize($object, $format, $context);
    }
}