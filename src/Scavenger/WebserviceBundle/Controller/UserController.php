<?php

namespace Scavenger\WebserviceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use \Symfony\Component\HttpFoundation\Response;
use \Scavenger\WebserviceBundle\Entity\User;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/")
     * @Method({"POST"})
     */
    public function userCreateAction()
    {
        /**
         * @var \Symfony\Component\HttpFoundation\Request
         */
        $request = $this->getRequest();
        $user = new User();

        $user->setName($request->get('name'));
        $user->setDeviceId($request->get('deviceId'));

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * @Route("/{id}/")
     * @Method({"POST"})
     *
     */
    public function userEditAction($id)
    {
        /**
         * @var \Symfony\Component\HttpFoundation\Request
         */
        $request = $this->getRequest();
        $user = $this->getUserRepository()->findOneById($id);

        $this->assertUserExists($user);

        $this->saveUserData($user, $this->getRequest());

        $response = new Response();
        $response->setStatusCode(200);

        return $response;
    }

    /**
     * @Route("/position/")
     * @Method({"GET"})
     */
    public function usePositionGet()
    {
        $criteria = array();
        $request = $this->getRequest();
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->addSelect('u')
                ->from('Scavenger\WebserviceBundle\Entity\User', 'u');


        if ($sessionId = $request->get('session')) {
            $qb->join('u.sessions', 's')->andWhere('s.id = :sessionId')->setParameter('sessionId', $sessionId);
        }

        $users = $qb->getQuery()->getResult();
        $res = array();

        foreach($users as $u) {
            $pos = array();
            $loc = $u->getLocations();

            $loc = $loc->last();

            if (false !== $loc) {
                $pos = array(
                    'lat' => $loc->getLat(),
                    'lng' => $loc->getLng()
                );
            }

            echo '<pre>';
            //var_dump($loc);

            $res = array(
                'id' => $u->getId(),
                'position' => $pos
            );
        }

        var_dump($res);
        die();

    }

    /**
     * @Route("/{id}/")
     * @Method({"GET"})
     */
    public function userGetById($id)
    {
        $repository = $this->getUserRepository();
        $user = $repository->findOneById($id);
        echo $user;
        die();


        return $this->handleGetResponse(new Response(), $user);
    }

    /**
     * @Route("/")
     * @Method({"GET"})
     */
    public function userGet()
    {

        $request = $this->getRequest();
        $repository = $this->getUserRepository();
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->addSelect('u')
                ->from('Scavenger\WebserviceBundle\Entity\User', 'u');


        if ($sessionId = $request->get('session')) {
            $qb->join('u.sessions', 's')->andWhere('s.id = :sessionId')->setParameter('sessionId', $sessionId);
        }

        if ($deviceId = $request->get('deviceId')) {
            $qb->andWhere('deviceId = :deviceId')->setParameter('deviceId', $deviceId);
        }


        $users = array();

        var_dump($qb->getQuery()->getArrayResult());
        die();

        foreach ($qb->getQuery()->getResult() as $u) {
            var_dump($u);
            //$pos = $u->getLocations();
            //echo $pos;
        }
        die();

        return $this->handleGetResponse(new Response(), $qb->getQuery()->getArrayResult());
    }


    private function saveUserData(User $user, $request)
    {
        $repository = $this->getUserRepository();

        $user->setName($request->get('name', $user->getName()));
        $user->setDeviceId($request->get('deviceId', $user->getDeviceId()));

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();

    }


    /**
     * @return \Scavenger\WebserviceBundle\Entity\UserRepository
     */
    private function getUserRepository()
    {
        return $this->container->get('sh.repository.user');
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->get("doctrine.orm.entity_manager");
    }

    private function assertUserExists($user)
    {
        if (null == $user) {
            throw new HttpException(404, 'User not found');
        }
    }

    private function handleGetResponse($response, $user)
    {
        $this->assertUserExists($user);

        $response->setStatusCode(200);

        $response->setContent(json_encode($user));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }
}
