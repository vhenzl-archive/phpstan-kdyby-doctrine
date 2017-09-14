<?php declare(strict_types = 1);

namespace PHPStanKdybyDoctrine\Type;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\GenericObjectType;
use PHPStan\Type\Type;
use PHPStanKdybyDoctrine\KdybyClasses;

class EntityRepositoryFindAssocDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{

	public static function getClass(): string
	{
		return KdybyClasses::ENTITY_REPOSITORY;
	}

	public function isMethodSupported(MethodReflection $methodReflection): bool
	{
		return in_array($methodReflection->getName(), [
			'findAssoc',
		], true);
	}

	public function getTypeFromMethodCall(
		MethodReflection $methodReflection,
		MethodCall $methodCall,
		Scope $scope
	): Type
	{
		$repositoryType = $scope->getType($methodCall->var);
		if (!($repositoryType instanceof GenericObjectType)) {
			return $methodReflection->getReturnType();
		}

		$type = new ArrayType($repositoryType->getGenericType());

		return $type;
	}

}
