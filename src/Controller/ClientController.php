<?php


namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 * Class ClientController
 * @package App\Controller
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_list")
     * @param ClientRepository $repository
     * @return Response
     */
    public final function index(ClientRepository $repository): Response {
        return $this->render("client/index.html.twig", [
            'clientList' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/insert-client/{name}")
     * @param string $name
     * @param EntityManagerInterface $manager
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */

    public final function insertClient(string $name, EntityManagerInterface $manager): Response {
        $client = new Client();
        $client->setName($name)
               ->setFirstName("vivi");
        $manager->persist($client);
        $manager->flush();

        return $this->redirectToRoute("client_list");
    }

    /**
     * @Route("/new", name="client_new")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public final function new(Request $request, EntityManagerInterface  $manager):Response {
        $client = new Client();
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($client);
            $manager->flush();

            return $this->redirectToRoute("client_list");
        }

        return $this->render("client/form.html.twig", [
            "clientForm" => $form->createView()
        ]);
    }
}