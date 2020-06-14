<?php
    namespace App\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Session\Session;
    use App\Entity\Book;

    class CartController extends AbstractController {
        
        /**
         * @Route("/cart", name="cart")
         * @Method({"GET"})
         */
        public function index()
        {
            $session = new Session();
            $cartItems = $session->get('cartItems');
            return $this->render('cart/index.html.twig', array('cartItems' => $cartItems));
        }

        /**
         * @Route("/cart/add/{id}", name="add_item_to_cart")
         * @Method({"GET"})
         */
        public function addItem($id)
        {
            $session = new Session();
            $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
            $cartItems = $session->get('cartItems');
            if(!$this->isItemExistInCart($book))
            {
                $cartItem = [];
                $cartItem['book'] = $book;
                $cartItem['count'] = 1;

                $cartItems[] = $cartItem;
                $session->set('cartItems', $cartItems);
                $this->updateCartOnChange();
                $message = $book->getName() . ' added to the cart.';
                $session->getFlashBag()->add('message', $message);
            }

            else
            {
                $message = $book->getName() . ' already in the cart.';
                $session->getFlashBag()->add('message', $message);
            }

            return $this->render('cart/index.html.twig', array('cartItems' => $cartItems));
        }
        
        /**
         * @Route("/cart/remove/{id}", name="remove_item_from_cart")
         * @Method({"GET"})
         */
        public function removeItem($id)
        {
            $session = new Session();
            $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
            $cartItems = $session->get('cartItems');

            if($this->isItemExistInCart($book))
            {
                $_cartItems = [];
                foreach($cartItems as $key => $cartItem)
                {
                    if($cartItem['book']->getId() != $id)
                        $_cartItems[] = $cartItem;
                }
                $cartItems = $_cartItems;
                $session->set('cartItems', $cartItems);
                $this->updateCartOnChange();
                $message = $book->getName() . ' removed from the cart.';
                $session->getFlashBag()->add('message', $message);
            }
            else
            {
                $message = $book->getName() . ' not found in the cart.';
                $session->getFlashBag()->add('message', $message);
            }

            return $this->render('cart/index.html.twig', array('cartItems' => $cartItems));
        }

        /**
         * @Route("/cart/update/{id}/{action}", name="update_item_count")
         * @Method({"GET"})
         */
        public function updateItem($id, $action)
        {
            $session = new Session();
            $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
            $cartItems = $session->get('cartItems');
            $_cartItems = [];

            if(in_array($action, ["increase", "decrease"])) {
                foreach($cartItems as $key => $cartItem)
                {
                    if($cartItem['book']->getId() == $id)
                    {
                        $_cartItem = [];
                        $_cartItem['book'] = $cartItem['book'];
                        $_cartItem['count'] = $cartItem['count'];

                        if($action == "increase")
                            $_cartItem['count'] = $cartItem['count'] + 1;
                        if($action == "decrease" && $cartItem['count'] > 1) {
                            $_cartItem['count'] = $cartItem['count'] - 1;
                        }

                        $_cartItems[] = $_cartItem;
                    }
                    else
                    {
                        $_cartItems[] = $cartItem;
                    }    
                }
                $cartItems = $_cartItems;
                $session->set('cartItems', $cartItems);
                $this->updateCartOnChange();
            }
            
            return $this->render('cart/index.html.twig', array('cartItems' => $cartItems));
        }


        private function isItemExistInCart($book)
        {
            $id = $book->getId();
            $session = new Session();
            $cartItems = $session->get('cartItems');
            
            if(!isset($cartItems))
                return false;

            foreach($cartItems as $key => $cartItem)
            {
                if($cartItem['book']->getId() == $id)
                    return true;
            }
            return false;
        }

        private function updateCartOnChange()
        {
            $session = new Session();
            $todalInCart = 0;
            $totalPrice = 0;
            $cartItems = $session->get('cartItems');
            foreach($cartItems as $key => $cartItem)
            {
                $todalInCart += $cartItem['count'];
                $totalPrice += $cartItem['book']->getPrice() * $cartItem['count'];
            }
            $session->set('todalInCart', $todalInCart);
            $session->set('totalPrice', $totalPrice);
            $session->set('displayPrice', $totalPrice);
            $session->set('discounts', []);
            $this->checkForDiscounts();
        }

        private function checkForDiscounts()
        {
            $session = new Session();
            $cartItems = $session->get('cartItems');
            $categoryWiseBookCount = [];
            $categoryWiseBookPrice = [];
            foreach($cartItems as $key => $cartItem)
            {
                if(isset($categoryWiseBookCount[$cartItem['book']->getCategory()->getId()]))
                {
                    $categoryWiseBookCount[$cartItem['book']->getCategory()->getId()] += $cartItem['count'];
                    $categoryWiseBookPrice[$cartItem['book']->getCategory()->getId()] += $cartItem['book']->getPrice() * $cartItem['count'];
                }
                else
                {
                    $categoryWiseBookCount[$cartItem['book']->getCategory()->getId()] = $cartItem['count'];
                    $categoryWiseBookPrice[$cartItem['book']->getCategory()->getId()] = $cartItem['book']->getPrice() * $cartItem['count'];
                }
            }

            if($this->checkForFivePlusChildrenbooksDiscount($categoryWiseBookCount))
            {
                $childrenBookTotal = $categoryWiseBookPrice[1]; // in my case children category is 1
                $discountForChildrenBooks = $childrenBookTotal * 0.1;
                $totalPrice = $session->get('totalPrice');
                $discountedTotal = $totalPrice - $discountForChildrenBooks;
                $discounts = $session->get('discounts');
                $discounts['fivePlusChild'] = $discountForChildrenBooks;
                $session->set('discounts', $discounts);
                $session->set('displayPrice', $discountedTotal);
            }

            if($this->checkForTenBooksForEachCategoryDiscount($categoryWiseBookCount))
            {
                $totalPrice = $session->get('totalPrice');
                $displayPrice = $session->get('displayPrice');
                $discountForTenBooksEachCategory = $totalPrice * 0.05;
                $discountedTotal = $displayPrice - $discountForTenBooksEachCategory;
                $discounts = $session->get('discounts');
                $discounts['tenBooksForEachCategory'] = $discountForTenBooksEachCategory;
                $session->set('discounts', $discounts);
                $session->set('displayPrice', $discountedTotal);
            }
        }

        private function checkForFivePlusChildrenbooksDiscount($categoryWiseBooks)
        {
            if(isset($categoryWiseBooks[1]) && $categoryWiseBooks[1] >= 5 ) // In my case children category id is 1
                return true;
            return false;
        }

        private function checkForTenBooksForEachCategoryDiscount($categoryWiseBooks)
        {
            if(isset($categoryWiseBooks[1]) && $categoryWiseBooks[1] >= 10 && isset($categoryWiseBooks[2]) && $categoryWiseBooks[2] >= 10 ) // we can loop instead of hard coding here
                return true;
            return false;
        }
    }