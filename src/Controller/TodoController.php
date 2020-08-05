<?php
    namespace App\Controller;

    use App\Entity\User;
    use App\Entity\Todo;
    use App\Form\RegistrationFormType;
    use App\Form\TodoType;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Exception\AccessDeniedException;
    use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
    

    class TodoController extends AbstractController{

        /**
         * @Route(name = "todo_index")
         */

        public function index(){
            return $this->render('index.html.twig');

        }


        /**
         * @Route("home", name = "todo_home")
         * @Method({"GET"})
         */

        public function home(){
            $todos = $this->getDoctrine()->getRepository(
                Todo::class)->findAll();
            

             return $this->render('home.html.twig', array('todos' => $todos));
        }


        /**
        * @Route("/todo/{id}", name = "todo_show")
        */

          public function show(Todo $todo = null, Request $request) {
              if(empty($todo)==false) {
              
                if($this->getUser()==$todo->getUserID()){
                    return $this->render('show.html.twig', array('todo' => $todo));
                }
                else {
                    $this->addFlash('error','Access denied!');
                    return $this->render('index.html.twig');
                }
              }
                else{
               $this->addFlash('error','Page not found!');
               return $this->render('index.html.twig');
            }
          } 

        /**
        * @Route("/new", name = "todo_new")
        * @Method({"GET", "POST"})
        */

        public function newTodo(Request $request){
            $todo = new Todo();

            $form = $this->createForm(TodoType::class,$todo);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $todo = $form->getData();
                $todo->setUserID($this->getUser());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($todo);
                $entityManager->flush();

                $this->addFlash('success', ' Todo is successfully created!');
                return $this->redirectToRoute('todo_home');
            }

            return $this->render('new.html.twig', array(
                'form' => $form->createView()));
           } 

        /**
        * @Route("/todo/delete/{id}")
        * @Method({"DELETE"})
        */
        public function deleteTodo(Todo $todo, Request $request){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($todo);
                $entityManager->flush();

                $response = new Response();
                $response->send();
        }

        /**
        * @Route("todo/update/{id}", name = "todo_update")
        * @Method({"GET", "POST"})
        */

        public function updateTodo(Request $request, Todo $todo){

            if($this->getUser()==$todo->getUserID()){

            
            $form = $this->createForm(TodoType::class,$todo);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                return $this->redirectToRoute('todo_home');
            }

            return $this->render('update.html.twig', array(
                'form' => $form->createView()));
            }
            else{ 
                throw new AccessDeniedException('Access denied. Ok???');
            }
        }

         
    }