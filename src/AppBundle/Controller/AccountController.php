<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Account;
use AppBundle\Entity\Account_Follower;
use AppBundle\Form\AccountType;

class AccountController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Put("/accounts/{id}")
     */
    public function updateAccountAction(Request $request)
    {
        return $this->updateAccount($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/accounts/{id}")
     */
    public function patchAccountAction(Request $request)
    {
        return $this->updateAccount($request, false);
    }

    private function updateAccount(Request $request, $clearMissing)
    {
        $account = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Account')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $account Account */

        if (empty($account)) {
            return new JsonResponse(['message' => 'Account not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(AccountType::class, $account);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($account);
            $em->flush();
            return $account;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/accounts/{id}")
     */
    public function removeAccountAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $account = $em->getRepository('AppBundle:Account')
                    ->find($request->get('id'));
        /* @var $account Account */

        if ($account) {
            $em->remove($account);
            $em->flush();
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/accounts")
     */
    public function postAccountsAction(Request $request)
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);

        $form->submit($request->request->all()); // Validation des données

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($account);
            $em->flush();
            return $account;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/accounts/{id}/follow/{id2}")
     */
    public function postFollowAction(Request $request)
    {
        $newfollower = new Account_Follower();

        $em = $this->get('doctrine.orm.entity_manager');

        $account1 = $em->getRepository('AppBundle:Account')
                       ->findOneOrCreate(array('idInsta' => $request->get('id')));

        $account2 = $em->getRepository('AppBundle:Account')
                       ->findOneOrCreate(array('idInsta' => $request->get('id2')));

        $newfollower -> setAccount($account1);
        $newfollower -> setFollower($account2);
        $newfollower -> setAction($request->get('action'));

        return $newfollower;

    }

    public function getAccountsAction(Request $request)
    {
        $accounts = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Account')
                ->findAll();
        /* @var $accounts Account[] */

        $formatted = [];
        foreach ($accounts as $account) {
            $formatted[] = [
               'id' => $account->getId(),
               'id_insta' => $account->getIdInsta(),
            ];
        }

        return new JsonResponse($formatted);
    }

    public function getAccountAction($id, Request $request)
    {
        $account = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Account')
                ->find($id);
        /* @var $account Account */

        if (empty($account)) {
            return new JsonResponse(['message' => 'Account not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
           'id' => $account->getId(),
           'id_insta' => $account->getIdInsta(),
        ];

        return new JsonResponse($formatted);
    }
}
