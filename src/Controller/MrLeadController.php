<?php

namespace App\Controller;

use App\Entity\MrBook;
use App\Entity\MrLead;
use App\Form\MrLeadType;
use App\Repository\MrLeadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MrLeadController extends AbstractController
{
  public function index(MrLeadRepository $mrLeadRepository): Response
  {
    $leads_out = array();
    $list = $mrLeadRepository->findBy(['identifier' => $this->getUserIdentifier()]);

    dd($this->getUserIdentifier());

    return $this->render('mr_lead/index.html.twig', [
      'mr_leads_arr' => $leads_out,
    ]);
  }

  public function getUserIdentifier(): string
  {
    $r = $_SERVER['REMOTE_ADDR'];
    $r .= $_COOKIE['PHPSESSID'] ?? '';
    $r = md5($r);

    return $r;
  }

  public function new(Request $request, MrBook $book): Response
  {
    $mrLead = new MrLead();
    $mrLead->addBookid($book);
    $mrLead->setStatus(MrLead::STATUS_NEW);
    $mrLead->setIdentifier($this->getUserIdentifier());

    $form = $this->createForm(MrLeadType::class, $mrLead);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid())
    {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($mrLead);
      $entityManager->flush();

      return $this->redirectToRoute('book.list');
    }

    return $this->render('mr_lead/new.html.twig', [
      'mr_lead' => $mrLead,
      'form'    => $form->createView(),
    ]);
  }

  public function show(MrLead $lead_id): Response
  {
    return $this->render('mr_lead/show.html.twig', [
      'mr_lead' => $lead_id,
    ]);
  }

  public function edit(Request $request, MrLead $lead_id): Response
  {
    $form = $this->createForm(MrLeadType::class, $lead_id);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('mr_lead_index');
    }

    return $this->render('mr_lead/edit.html.twig', [
      'mr_lead' => $lead_id,
      'form'    => $form->createView(),
    ]);
  }

  public function delete(Request $request, MrLead $lead_id): Response
  {
    if ($this->isCsrfTokenValid('delete' . $lead_id->getId(), $request->request->get('_token')))
    {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($lead_id);
      $entityManager->flush();
    }

    return $this->redirectToRoute('mr_lead_index');
  }
}
