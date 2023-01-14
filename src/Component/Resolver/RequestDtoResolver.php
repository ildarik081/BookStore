<?php

namespace App\Component\Resolver;

use App\Component\Interface\AbstractDtoControllerRequest;
use Generator;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    /** Ключ сессии */
    private const SESSION = 'session';

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), AbstractDtoControllerRequest::class);
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return Generator
     */
    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        if ($request->getSession()->has(self::SESSION)) {
            $session = $request->getSession()->get(self::SESSION);
        } else {
            $session = uniqid(more_entropy: true);
            $request->getSession()->set(self::SESSION, $session);
        }

        if (Request::METHOD_GET === $request->getMethod()) {
            $data = (string) json_encode($request->query->all(), JSON_THROW_ON_ERROR);
        } else {
            $data = (string) $request->getContent();
        }

        /** @var AbstractDtoControllerRequest $result */
        $result = $this->serializer->deserialize($data, $argument->getType(), 'json');
        $result->session = $session;

        yield $result;
    }
}
