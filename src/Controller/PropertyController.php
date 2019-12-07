<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class PropertyController extends AbstractController
{

     /**
         * Undocumented variable
         *
         * @var PropertyRepository
         */
        private $repository;

        private $em;

        /**
         * __construct
         *
         * @param  mixed $repository
         *
         * @return void
         */
        public function __construct(PropertyRepository $repository)
        {
            return $this->repository = $repository;
        }

    /**
     * @Route("/biens", name="property")
     */
    public function index(EntityManagerInterface $em): Response
    {      

        /**
         * 1- methode SF 2 et 3
         * Cette methode audessus montre en manuel comment
         * instancier un objet de entity Property et le mapper avec des donner ensuite
         * enregtrement persist ensuite flush
         */
        // $property = new Property();
        // $property->setTitle('Mon premier bien a vendre')
        //         ->setPrice(200000)
        //         ->setRooms(4)
        //         ->setBedrooms(3)
        //         ->setDescription('Une petite description')
        //         ->setSurface(60)
        //         ->setFloor(4)
        //         ->setHeat(1)
        //         ->setCity('Paris')
        //         ->setAdresse('boulvard de la gare')
        //         ->setPostalCode(75010)
        //         ;
                // $em = $this->getDoctrine()->getManager();

                /**
                 * 2- Methode sf 3 
                 * creer un var repo qui prend getRepository(Property::clas)
                 * cette obj $repo contient toute les var de table property
                 */
                // $repo = $this->getDoctrine()->getRepository(Property::class);

                /**
                 * 3- Methode c la autowiring
                 * on a directement obj $repo = this_>repository
                 * par injection de dependence 
                 */
                $repo = $this->repository->findAllVisible();
                // $repo[0]->setSold(false);
                

                // $em->persist();
                $em->flush();
        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'properties'
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug": "[a-zA-Z1-9\-_\/]+", "id": "\d+"} )
     *
     * @return Response
     */
    // public function show($slug, $id): Response
    public function show(Property $property, string $slug): Response
    {

        if($property->getSlug() !== $slug){
           return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug(),
                'current_menu' => 'properties',
            'property' => $property
            ], 301);
        }

        // $property = $this->repository->find($property->getId());

        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property' => $property

        ]);

    }


}
