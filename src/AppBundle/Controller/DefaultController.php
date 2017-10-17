<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('default/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setTitle('Category title');

        $product = new Product();
        $product->setTitle('Product title');
        $product->setPrice(123.56);
        $product->setActive(true);
        $product->setCategory($category);

        $em->persist($product);

        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteAction(Product $product)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($product);

        $em->flush();

        return $this->redirectToRoute('homepage');
    }
}
