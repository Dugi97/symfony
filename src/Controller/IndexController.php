<?php

namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article = $entityManager->getRepository(Article::class)->findAll();


        return $this->render('index/index.html.twig', [
            'articles' =>$article
        ]);
    }


    /**
     * @Route("/article", name="save")
     */
    public function save()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article = $entityManager->getRepository(Article::class)->findAll();


        return $this->render('index/index.html.twig',
            [
                'results' => $article
            ]
        );
    }

    /**
     * @Route("/dugi", name="dugi")
     */
    public function dugi()
    {

        return $this->render('index/dugalic.html.twig');
    }

    /**
     * @Route("/form", name="form")
     * Method({"GET","POST"})
     */
    public function form(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article2 = new Article();
        $form = $this->createForm(ArticleType::class, $article2);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($article2);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }


        return $this->render('index/form.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    /**
     * @Route("/delete/{id}", name="dugi")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }


    /**
     * @Route("/edit/{id}", name="edit")
     * Method({"GET","POST"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Article $article
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Request $request, EntityManagerInterface $em, Article $article, $id)
    {


        if (isset($_POST['submit']))
        {

            $article->setTitle($_POST['title']);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('index/edit.html.twig',
            [
                'articles' => $article
            ]);
    }








}


/*
 *       Entity manager
 *       $entityManager = $this->getDoctrine()->getManager();
 *
 *       prosledjuje promenu entity manageru
 *       $entityManager->persist($article);

         zavrsava promenu
         $entityManager->flush();

         ulazak u mysql
        mysql -u root

        za prikaz baza
        show databases

        za prikaz tabela
        show tables

        za koriscenje odredjene tabele
        use naziv_tabele

        za vracanje svih podataka iz tabele

        $article = $entityManager->getRepository(Article::class)->findAll();

        Kreiranje forme u konzoli
        php bin/console make:form


            // KOD ZA KREIRANJE FORME
 public function form(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $article2 = new Article();
        $form = $this->createForm(ArticleType::class, $article2);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($article2);
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }


        return $this->render('index/form.html.twig',
            [
                'form' => $form->createView()
//            ]);
//    }
//
//    KOD ZA IZVLACENJE PODATAKA IZ BAZE
//    /**
//     * @Route("/article", name="save")
//     * /
//public function save()
//{
//    $entityManager = $this->getDoctrine()->getManager();
//
//    $article = $entityManager->getRepository(Article::class)->findAll();
//
//    /** @var Article $article * /
//
//
//
//    return $this->render('index/index.html.twig',
//        [
//            'results' => $article
//        ]
//    );

//}

      KOD ZA BRISANJE NA OSNOVU ID

         public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }

//*/


