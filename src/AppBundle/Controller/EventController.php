<?php
namespace AppBundle\Controller;
// We include the entity that we create in our Controller file
use AppBundle\Entity\Events;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// Now we need some classes in our Controller because we need that in our form (for the inputs that we will create)
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class EventController extends Controller
{
   /**
    * @Route("/", name="listEvent")
    */
   public function listEvent(){

// Here we will use getDoctrine to use doctrine and we will select the entity that we want to work with and we used findAll() to bring all the information from it and we will save it inside a variable named events and the type of the result will be an array 
       $events = $this->getDoctrine()->getRepository('AppBundle:Events')->findAll();
       // replace this example code with whatever you need
       return $this->render('events/index.html.twig', array('events'=>$events));
   }
    /**
    * @Route("/events/create", name="createEvent")
    */
   public function createEvent(Request $request){

// Here we create an object from the class that we made 
       $events = new Events;

/* Here we will build a form using createFormBuilder and inside this function we will put our object and then we write add then we select the input type then an array to add an attribute that we want in our input field */
       $form = $this->createFormBuilder($events)
    ->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('start', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
    ->add('end', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
    ->add('description', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('capacity', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('email', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('phone', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('streetname', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('streetnumber', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('zip', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('city', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('url', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
    ->add('type', ChoiceType::class, array('choices'=>array('music'=>'music', 'sport'=>'sport', 'movie'=>'movie', 'theater'=>'theater', 'show'=>'show'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
    ->add('save', SubmitType::class, array('label'=> 'Create Event', 'attr' => array('class'=> 'btn-primary', 'style'=>'margin-bottom:15px')))
       ->getForm();
       $form->handleRequest($request);


/* Here we have an if statement, if we click submit and if  the form is valid we will take the values from the form and we will save them in the new variables */
       if($form->isSubmitted() && $form->isValid()){
           //fetching data
           $name = $form['name']->getData();
           $start = $form['start']->getData();
           $end = $form['end']->getData();
           $description = $form['description']->getData();
           $image = $form['image']->getData();
           $capacity = $form['capacity']->getData();
           $email = $form['email']->getData();
           $phone = $form['phone']->getData();
           $streetname = $form['streetname']->getData();
           $streetnumber = $form['streetnumber']->getData();
           $zip = $form['zip']->getData();
           $city = $form['city']->getData();
           $url = $form['url']->getData();
           $type = $form['type']->getData();

// Here we will get the current date
           $now = new\DateTime('now');


/* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
           $events->setName($name);
           $events->setStart($start);
           $events->setEnd($end);
           $events->setDescription($description);
           $events->setImage($image);
           $events->setCapacity($capacity);
           $events->setEmail($email);
           $events->setPhone($phone);
           $events->setStreetname($streetname);
           $events->setStreetnumber($streetnumber);
           $events->setZip($zip);
           $events->setCity($city);
           $events->setUrl($url);
           $events->setType($type);
           $events->setCreateDate($now);
           $em = $this->getDoctrine()->getManager();
           $em->persist($events);
           $em->flush();
           $this->addFlash(
                   'notice',
                   'Event Added'
                   );
           return $this->redirectToRoute('listEvent');
       }
/* now to make the form we will add this line form->createView() and now you can see the form in create.html.twig file  */
       return $this->render('events/create.html.twig', array('form' => $form->createView()));
   }
    /**
    * @Route("/events/edit/{id}", name="editEvent")
    */
   public function editEvent( $id, Request $request){
 /* Here we have a variable todo and it will save the result of this search and it will be one result because we search based on a specific id */
   $event = $this->getDoctrine()->getRepository('AppBundle:Events')->find($id);
$now = new\DateTime('now');

/* Now we will use set functions and inside this set functions we will bring the value that is already exist using get function for example we have setName() and inside it we will bring the current value and use it again */
           $event->setName($event->getName());
           $event->setStart($event->getStart());
           $event->setEnd($event->getEnd());
           $event->setDescription($event->getDescription());
           $event->setImage($event->getImage());
           $event->setCapacity($event->getCapacity());
           $event->setEmail($event->getEmail());
           $event->setPhone($event->getPhone());
           $event->setStreetname($event->getStreetname());
           $event->setStreetnumber($event->getStreetnumber());
           $event->setZip($event->getZip());
           $event->setCity($event->getCity());
           $event->setUrl($event->getUrl());
           $event->setType($event->getType());
           $event->setCreateDate($now);

/* Now when you type createFormBuilder and you will put the variable todo the form will be filled of the data that you already set it */
       $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
      ->add('start', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
      ->add('end', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px'))) 
       ->add('description', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
        ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
         ->add('capacity', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
       ->add('email', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('phone', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('streetname', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('streetnumber', IntegerType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('zip', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('city', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('url', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
       ->add('type', ChoiceType::class, array('choices'=>array('music'=>'music', 'sport'=>'sport', 'movie'=>'movie', 'theater'=>'theater', 'show'=>'show'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
     
   
   ->add('save', SubmitType::class, array('label'=> 'Update Event', 'attr' => array('class'=> 'btn-primary', 'style'=>'margin-botton:15px')))
       ->getForm();
       $form->handleRequest($request);
       if($form->isSubmitted() && $form->isValid()){
           //fetching data
           $name = $form['name']->getData();
           $start = $form['start']->getData();
           $end = $form['end']->getData();
           $description = $form['description']->getData();
           $image = $form['image']->getData();
           $capacity = $form['capacity']->getData();
           $email = $form['email']->getData();
           $phone = $form['phone']->getData();
           $streetname = $form['streetname']->getData();
           $streetnumber = $form['streetnumber']->getData();
           $zip = $form['zip']->getData();
           $city = $form['city']->getData();
           $url = $form['url']->getData();
           $type = $form['type']->getData();
           $now = new\DateTime('now');
           $em = $this->getDoctrine()->getManager();
           $event = $em->getRepository('AppBundle:Events')->find($id);
           $event->setName($name);
           $event->setStart($start);
           $event->setEnd($end);
           $event->setDescription($description);
           $event->setImage($image);
           $event->setCapacity($capacity);
           $event->setEmail($email);
           $event->setPhone($phone);
           $event->setStreetname($streetname);
           $event->setStreetnumber($streetnumber);
           $event->setZip($zip);
           $event->setCity($city);
           $event->setUrl($url);
           $event->setType($type);
           $event->setCreateDate($now);
        
           $em->flush();
           $this->addFlash(
                   'notice',
                   'Event Updated'
                   );
           return $this->redirectToRoute('listEvent');
       }
       return $this->render('events/edit.html.twig', array('event' => $event, 'form' => $form->createView()));
   }
    /**
    * @Route("/events/details/{id}", name="detailsEvent")
    */
   public function detailsEvent($id){
       // replace this example code with whatever you need
        $events = $this->getDoctrine()->getRepository('AppBundle:Events')->find($id);
       return $this->render('events/details.html.twig', array('events' => $events));
   }

    /**
    * @Route("/events/delete/{id}", name="deleteEvent")
    */
   public function deleteEvent($id){
                $em = $this->getDoctrine()->getManager();
           $events = $em->getRepository('AppBundle:Events')->find($id);
           $em->remove($events);
            $em->flush();
           $this->addFlash(
                   'notice',
                   'Event Removed'
                   );
            return $this->redirectToRoute('listEvent');
   }
}