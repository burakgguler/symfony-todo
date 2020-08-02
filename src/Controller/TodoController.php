<?php
    namespace App\Controller;

    use App\Entity\User;
    use App\Entity\Todo;
    use App\Form\NewTodoType;
    use App\Form\RegistrationFormType;
    use App\Form\UpdateTodoType;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Exception\AccessDeniedException;
    use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


    class TodoController extends AbstractController{
        /**
         * @Route(name = "todo_index")
         */
        public function index(){
            return $this->render('index.html.twig');

        }

       // /**
       //  * @Route("/user/new", name = "new_user")
       //  * @Method({"GET", "POST"})
        // */
       /* public function newUser(Request $request){
            $user = new User();

            $form = $this->createForm(RegisterType::class, $user);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $user = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('todo_index');
            }

            return $this->render('register.html.twig', array(
                'form' => $form->createView()
            ));
        } */

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
          * 
          */ 

          /**
           * @Route("/todo/{id}", name = "todo_show")
           */
          public function show(Todo $todo) {
              if($this->getUser()==$todo->getUserID()){
                return $this->render('show.html.twig', array('todo' => $todo));
              }
              else {
                throw new AccessDeniedException('Access denied. Ok???');
              }
          } 

          /**
           * @Route("/new", name = "todo_new")
           * @Method({"GET", "POST"})
           */

           public function newTodo(Request $request){
               $todo = new Todo();

               $form = $this->createForm(UpdateTodoType::class,$todo);

               $form->handleRequest($request);

               if($form->isSubmitted() && $form->isValid()) {
                   $todo = $form->getData();
                   $todo->setUserID($this->getUser());

                   $entityManager = $this->getDoctrine()->getManager();
                   $entityManager->persist($todo);
                   $entityManager->flush();

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

            
            $form = $this->createForm(UpdateTodoType::class,$todo);

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