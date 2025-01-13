<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $data = new ContactDTO();

        $data->name = 'John Doe';
        $data->email = 'john@gmail.com';
        $data->message = 'Hello, I am John Doe';

        $form = $this->createForm(ContactType::class, $data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $email = (new TemplatedEmail())
                    ->from($data->service)
                    ->to($data->email)
                    ->subject('Thanks for signing up!')
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context([
                        'data' => $data,
                    ]);
                $mailer->send($email);
                $this->addFlash('success', 'Email sent successfully!');
                $this->redirectToRoute('contact');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred while sending the email: ' . $e->getMessage());
            }
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
