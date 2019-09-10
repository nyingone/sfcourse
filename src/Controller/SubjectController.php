<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/subject", name="subject.")
*/

class SubjectController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param SubjectRepository $subjectRepository
     * @return Response
     */
    public function index(SubjectRepository $subjectRepository)
    {
        $subjects = $subjectRepository->findAll();

       //  dump($subjects);

        return $this->render('subject/index.html.twig', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response 
     */
    public function create(Request $request)
    {
        // create a Subject with title
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);

        $form->handleRequest($request);

        $form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            // dump($request->files);
           $file = $request->files->get('subject')['attachment'];
           if($file){
               $filename = md5(uniqid()) . '.' . $file->guessClientExtension();
               
               $file->move(
                   $this->getParameter('uploads_dir') ,
                    $filename
               );

               $subject->setImage($filename);
            }

            $em->persist($subject);
            $em->flush(); 

            return $this->redirect($this->generateUrl('subject.index'));
        }

        // entity manager
        
        // 

        // return a response  a view
        // return new Response('Sujet créé');
        // return $this->redirect($this->generateUrl('subject.index'));
        return $this->render('subject/create.html.twig', [
            'form' => $form->createView()
        ]);


    }
    /**
    * @Route("/show/{id}", name="show")
    * @param Request $request
    * @return Response 
    */
    public function show(Subject $subject)
    {
        // $subject = $subjectRepository->find($id);
       // dump($subject); die;
        return $this->render('subject/show.html.twig', [
            'subject' => $subject
        ]);

    }


    /**
    * @Route("/delete/{id}", name="delete")
    * @param Request $request
    * @return Response 
    */
    public function remove(Subject $subject)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($subject);
        $em->flush();

        $this->addFlash('alert alert-success', 'Sujet bien supprimé');
        return $this->redirect($this->generateUrl('subject.index'));

    }

    
}
