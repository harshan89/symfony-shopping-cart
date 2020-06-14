<?php
    namespace App\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Session\Session;
    use App\Entity\Book;

    class BooksController extends AbstractController {
        /**
         * @Route("/", name="home")
         * @Method({"GET"})
         */
        public function index(Request $request)
        {
            if($request->query->get('category'))
                $books = $this->getDoctrine()->getRepository(Book::class)->findBy([ 'category' => $request->query->get('category') ]);
            else
                $books = $this->getDoctrine()->getRepository(Book::class)->findAll();

            return $this->render('books/index.html.twig', array('books' => $books));
        }

        /**
         * @Route("/book/save")
         * @Method({"GET"})
         */
        public function save()
        {
            $entityManager = $this->getDoctrine()->getManager();
            $book = new Book();
            $book->setName('xx');
            $book->setThumb('thumb');
            $book->setDescription('book description');
            $book->setAuthor('Author');
            $book->setRate(4.5);
            $book->setCategory(1);
            $entityManager->persist($book);
            $entityManager->flush();
            return new Response('Saves a book with book id ' . $book->getId());
        }
        /**
         * @Route("/book/{id}", name="book_show")
         * @Method({"GET"})
         */
        public function show($id)
        {
            $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
            return $this->render('books/show.html.twig', array('book' => $book));
        }
    }