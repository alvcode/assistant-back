<?php

namespace App\EventListener;

use App\InfrastructureFacades\Lang;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Translation\TranslatorInterface;

class LangListener
{
    private TranslatorInterface $symfonyTranslator;

    public function __construct(TranslatorInterface $symfonyTranslator)
    {
        $this->symfonyTranslator = $symfonyTranslator;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        Lang::setTranslator($this->symfonyTranslator);
    }
}