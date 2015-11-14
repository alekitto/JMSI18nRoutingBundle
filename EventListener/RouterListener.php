<?php
namespace JMS\I18nRoutingBundle\EventListener;
use JMS\I18nRoutingBundle\Router\I18nRouter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Sets the current request into the i18n router
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class RouterListener implements EventSubscriberInterface
{
    private $requestStack;

    private $router;

    public function __construct(RequestStack $requestStack, I18nRouter $router)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    public function onKernelRequest()
    {
        $this->router->setRequest($this->requestStack->getCurrentRequest());
    }

    public function onKernelFinishRequest()
    {
        $this->router->setRequest($this->requestStack->getParentRequest());
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array(array('onKernelRequest', 32)),
            KernelEvents::FINISH_REQUEST => array(array('onKernelFinishRequest', 0)),
        );
    }
}
