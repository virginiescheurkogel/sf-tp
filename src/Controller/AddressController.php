<?php


namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressFormType;
use App\Repository\AddressRepository;
use App\Repository\AdressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/address")
 * Class AddressController
 * @package App\Controller
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="address_list")
     * @param AddressRepository $addressRepository
     * @return Response
     */
    public final function list(AddressRepository $addressRepository): Response {
        return $this->render("address/list.html.twig", [
            "addressList" => $addressRepository->findAll()
        ]);
    }


    /**
     * @Route("/insert-address/{street}")
     * @param string $street
     * @param EntityManagerInterface $manager
     * @return Response
     */

    public final function insertAddress(string $street, EntityManagerInterface $manager): Response {
        $address = new Address();
        $address->setStreet($street)
            ->setZipCode("69000")
            ->setCity("Lyon");
        $manager->persist($address);
        $manager->flush();

        return $this->redirectToRoute("address_list");
    }

    /**
     * @Route("/new", name="address_new")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public final function new(Request $request, EntityManagerInterface  $manager):Response {
        $address = new Address();
        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($address);
            $manager->flush();

            return $this->redirectToRoute("address_list");
        }

        return $this->render("address/form.html.twig", [
            "addressForm" => $form->createView()
        ]);
    }
}