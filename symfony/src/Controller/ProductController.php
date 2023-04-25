<?php
// src/Controller/ProductController.php
namespace App\Controller;

// ...
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');
        $newproduct = new Product();
        $newproduct->SetName('Mouse');
        $newproduct->setPrice(2000);
        $newproduct->SetDescription('Wireless mouse');
// tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);
        $entityManager->persist($newproduct);

// actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '  . "</br>First Product " . $product->getId() . "</br>Second Product  " . $newproduct->getId());

    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }
        return new Response('Check out this great product: ' . $product->getName() . '</br>' . $product->getPrice() . '</br>' . $product->getDescription() );
    }


    public function addCategoty(Request $request, EntityManagerInterface $entityManager): Response
    {
        // creates a task object and initializes some data for this example
        $task = new Category();
//        $task->setTask('Write a blog post');
//        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $entityManager->persist($task);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('product/newCategory.html.twig', [
            'form' => $form,
        ]);

        // ...
    }
}
