<?php
    namespace App\Controller;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Session\Session;
    use App\Entity\Book;

    class CheckoutController extends AbstractController {
        
        /**
         * @Route("/checkout", name="checkout")
         * @Method({"GET"})
         */
        public function index()
        {
            $session = new Session();
            $cartItems = $session->get('cartItems');
            $discounts = $session->get('discounts');
            if(isset($discounts['couponCodeDiscount']))
            $discounts = ['couponCodeDiscount' => $discounts['couponCodeDiscount']];
            return $this->render('checkout/index.html.twig', array('cartItems' => $cartItems, 'discounts' => $discounts));
        }

        /**
         * @Route("/checkout/coupon_code", name="coupon_code")
         * @Method({"GET"})
         */
        public function applyCouponCode()
        {
            $session = new Session();
            $cartItems = $session->get('cartItems');
            $totalPrice = $session->get('totalPrice');
            $discountForCouponCode = $totalPrice * 0.15;
            $discountedTotal = $totalPrice - $discountForCouponCode;
            $discounts = $session->get('discounts');
            $discounts['couponCodeDiscount'] = $discountForCouponCode;
            $session->set('discounts', $discounts);
            $session->set('displayPrice', $discountedTotal);
            $discounts = ['couponCodeDiscount' => $discountForCouponCode];
            return $this->render('checkout/index.html.twig', array('cartItems' => $cartItems, 'discounts' => $discounts));
        }
    }