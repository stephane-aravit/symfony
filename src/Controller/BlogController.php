<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="blog_home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(TranslatorInterface $translatorInterface)
    {
        return $this->render('blog/index.html.twig', [
            'message' => $translatorInterface->trans('This is an example of translated text !')
        ]);
    }

    /**
     * @Route("/changeLocale/{locale}", name="change_locale")
     */    
    public function changeLocale($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);
        //dd($request);
        return $this->redirect($request->headers->get('referer'));
    }
}
