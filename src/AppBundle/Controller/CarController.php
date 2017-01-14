<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Cash;
use AppBundle\Entity\Produktas;
use AppBundle\Entity\Shop;
use AppBundle\Entity\Skateboard;
use AppBundle\Form\CarType;
use AppBundle\Form\ShopType;
use AppBundle\Service\MathService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DecimalType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 *
 * Class CarController
 *
 * @Route("/car")
 */
class CarController extends Controller

{

    /**
     * @Route("/",name="car_index")
     */
    public function indexAction(Request $request){

      /*  $math = $this->get('app.math');
        $res = $math->addNumbers(2,3);
        dump($res);
        return new Response();*/


        $form = $this -> createFormBuilder()

            ->add('SHOP', SubmitType::class, [
                'label' => 'SHOP',
                'attr' => [
                    'class' => 'button_test'
                ]
            ])
            ->getForm()
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('shop');
        }


        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;



       // dump($request-> query->get('comment'));

        $repo = $this->getDoctrine()->getRepository('AppBundle:Produktas');
        $repo2 = $this->getDoctrine()->getRepository('AppBundle:Car');
         $cars = $repo2->findAll();
        $produktas = $repo->find(1);
        //$custom = $repo -> find(1);
       // $custom1 = $custom->getKaina();
      // dump($custom1);
      // return new Response();




       return $this->render('@FOSUser/Security/index.html.twig',[
           'cars' => $cars,
            'kaina' => $produktas->getKaina(),
           'last_username' => $lastUsername,
           'error' => $error,
           'csrf_token' => $csrfToken,
           'user_roles'=>$this->getUser() ? $this->getUser()->getRoles() : null,
           'form'=> $form ->createView(),
        ]);
    }



    /**
     * @Route("/upload-target")
     */
    public function uploadAction(Request $request)
    {



        return new Response('ok');
    }


    /**
     * @Route("/ad",name="add_produktas")
     * @param Request $request
     * @return Response
     */

    public function addAction2(Request $request)
    {

        $produktas = new Produktas();
        $em = $this ->getDoctrine()->getManager();


        // Create our form
        $form = $this -> createFormBuilder($produktas)
            ->add('kaina',NumberType::class)
            ->add('save',SubmitType::class,['label' => 'Add money'])
            ->getForm()
        ;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // Istraukiu is duombazes Objekta
           $baze = $em->getRepository('AppBundle:Produktas')->find(1);

            $baze->setKaina( $baze->getKaina() + $produktas->getKaina() );

            $em->flush();


            return $this->redirectToRoute('car_index');
        }



        return $this->render('car/add.html.twig',[
                'produktas' => $produktas,
                'forma'=> $form ->createView(),
                'edit' =>false,
            ]
        );}








    /**
     * @Route ("/edit/{skateboard}",name="edit_car")
     * @param Request $request
     * @param Car $car
     * @return Response
     */

        public function editAction(Request $request, Skateboard $skateboard){


                $form = $this->createForm(CarType::class, $skateboard)

            ;
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {


                $em = $this ->getDoctrine()->getManager();

                $em->flush();


                return $this->redirectToRoute('car_index');
            }

            return $this->render('car/add.html.twig',[
                    'car' => $car,
                    'forma'=> $form ->createView(),
                'edit' =>true,
            ]);



    }

    /**
     * @Route ("-delete/{car}",name="delete_car")
     */

    public function deleteAction(Request $request, Car $car){

        $form = $this -> createFormBuilder($car)
            ->add('save',SubmitType::class,['label' => 'Buy'])
            ->getForm();

        $form2 = $this -> createFormBuilder($car)
            ->add('save2',SubmitType::class,['label' => 'Back'])
            ->getForm();


        $form->handleRequest($request);
        $form2->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {


            $em = $this ->getDoctrine()->getManager();
            $baze = $em->getRepository('AppBundle:Produktas')->find(1);
           $price =$car->getPrice();



          if($price < $baze->getKaina()) {
            $baze->setKaina($baze->getKaina() - $price);
               $em->remove($car);
         }
         else{

             $this->addFlash(
                 'notice',
                 'Not enough money'
             );
         }

            $em->flush();
            return $this->redirectToRoute('car_index');
        }



        if ($form2->isSubmitted() && $form2->isValid()) {


            return $this->redirectToRoute('car_index');
        }


        return $this->render('car/delete.html.twig',[
                'car' => $car,
                'forma'=> $form ->createView(),
                'forma2'=> $form2 ->createView(),
            ]
        );
    }
}
