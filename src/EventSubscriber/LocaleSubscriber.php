<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __contruct($defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) { return; }
        
        // La langue est passée en paramètre de l'url ?
        if ($locale = $request->query->get('_locale')) {
            $request->setLocale($locale);
        // Si non on passe la langue enregistrée en session
        } else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            //'request' => 'onRequest',
            KernelEvents::REQUEST => [['onRequest', 20]],
        ];
    }
}
