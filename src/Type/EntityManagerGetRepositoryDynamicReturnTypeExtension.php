<?php declare(strict_types = 1);

namespace PHPStanKdybyDoctrine\Type;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Reflection\BrokerAwareClassReflectionExtension;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\GenericObjectType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStanKdybyDoctrine\KdybyClasses;

class EntityManagerGetRepositoryDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension, BrokerAwareClassReflectionExtension
{

	/** @var \PHPStan\Type\Doctrine\EntityManagerGetRepositoryDynamicReturnTypeExtension */
	private $entityManagerGetRepositoryExtension;

	public function __construct(
		\PHPStan\Type\Doctrine\EntityManagerGetRepositoryDynamicReturnTypeExtension $entityManagerGetRepositoryExtension
	)
	{
		$this->entityManagerGetRepositoryExtension = $entityManagerGetRepositoryExtension;
	}

	/** @var \PHPStan\Broker\Broker */
	private $broker;

	public function setBroker(Broker $broker)
	{
		$this->broker = $broker;
	}

	public static function getClass(): string
	{
		return KdybyClasses::ENTITY_MANAGER;
	}

	public function isMethodSupported(MethodReflection $methodReflection): bool
	{
		$supported = in_array($methodReflection->getName(), [
			'getRepository',
		], true);
		return $supported;
	}

	public function getTypeFromMethodCall(
		MethodReflection $methodReflection,
		MethodCall $methodCall,
		Scope $scope
	): Type
	{
		$returnType = $this->entityManagerGetRepositoryExtension->isMethodSupported($methodReflection)
			? $this->entityManagerGetRepositoryExtension->getTypeFromMethodCall($methodReflection, $methodCall, $scope)
			: $methodReflection->getReturnType();

		$hasKdybyManager = $this->broker->hasClass(KdybyClasses::ENTITY_REPOSITORY);

		if ($returnType instanceof GenericObjectType) {
			return $hasKdybyManager === true
				? new GenericObjectType(KdybyClasses::ENTITY_REPOSITORY, $returnType->getGenericType())
				: $returnType;
		} elseif ($hasKdybyManager) {
			return new ObjectType(KdybyClasses::ENTITY_REPOSITORY);
		} else {
			return $returnType;
		}
	}

}
