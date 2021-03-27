<?php


namespace App\Controller;


use App\Entity\Invoice;
use App\Form\InvoiceFormType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/invoice")
 * Class InvoiceController
 * @package App\Controller
 */
class InvoiceController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/", name="invoice_list")
     * @param InvoiceRepository $invoiceRepository
     * @return Response
     */
    public final function index(InvoiceRepository $invoiceRepository): Response {
        return $this->render("invoice/list.html.twig", [
            'invoiceList' => $invoiceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/insert-invoice/{number}")
     * @param $number
     * @param EntityManagerInterface $manager
     * @return Response
     */

    public final function insertInvoice($number, EntityManagerInterface $manager): Response {
        $invoice = new Invoice();
        $invoice->setDate(new \DateTime())
                ->setNumber($number)
                ->setDiscountRate("10")
                ->setItems("ordinateur");
        $manager->persist($invoice);
        $manager->flush();

        return $this->redirectToRoute("invoice_list");
    }

    /**
     * @Route("/new", name="invoice_new")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public final function new(Request $request, EntityManagerInterface  $manager):Response {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceFormType::class, $invoice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($invoice);
            $manager->flush();

            return $this->redirectToRoute("invoice_list");
        }

        return $this->render("invoice/form.html.twig", [
            "invoiceForm" => $form->createView()
        ]);
    }
}