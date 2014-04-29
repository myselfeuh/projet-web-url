<?php

namespace UrlReducer\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\UserBundle\Entity\User;
use UrlReducer\UserBundle\Service\Authentifier;
use UrlReducer\CoreBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;

class AccessLevelException extends \Exception {};
class AdminControllerException extends \Exception {};

/**
 *
 */
class AdminController extends AbstractUserController {
	/**
	 *
	 */
	public function manageAction(Request $oRequest) {
		$oAuthentifier = $this->container->get('url_reducer_user.authentifier');
        $oFlashBag = $this->get('session')->getFlashbag();

    	try {
    		if ($oAuthentifier->getStatus() != Authentifier::IS_ADMIN) {
    			throw new AccessLevelException;
    		}

    		$oUser = $oAuthentifier->getUser();

    		// handle form
		    $oFormMemberManage = $this->constructManageMemberForm($oUser);
		    $oFormMemberManage->handleRequest($oRequest);

            $oResponse = $this->render(
                'UrlReducerUserBundle:Admin:manage.member.html.twig',
                array('form_manage_member' => $oFormMemberManage->createView())
            );

		    if ($oFormMemberManage->isValid()) {
                $aFormData = $oFormMemberManage->getData();

                $sMessage = "Aucun changement n'a été effectué"; 

                if ($oFormMemberManage->get('valider')->isClicked()) {
                    if ($aFormData['profil'] == null) {
                        throw new AdminControllerException($sMessage);
                    } else if (empty($aFormData['selected_user'])) {
                        throw new AdminControllerException($sMessage);
                    } else {
                        $this->changeMemberProfil($aFormData['profil'], $aFormData['selected_user']);
                    }
                } else if ($oFormMemberManage->get('supprimer')->isClicked()) {
                    if (empty($aFormData['selected_user'])) {
                        throw new AdminControllerException($sMessage);
                    } else {
                        $this->deleteMember($aFormData['selected_user']);
                    }
                } else {
                    throw new AdminControllerException($sMessage);
                }
		    } 
    	} catch (AccessLevelException $e) {
    		$oResponse = $this->renderAccessLevelException();
    	} catch (AdminControllerException $e) {
            // @TODO
        }

        return $oResponse;
	}

    /**
     *
     */
    public function changeMemberProfil($sProfil, $aUserIds) {
        $oEntityManager = $this->getDoctrine()->getEntityManager();
        $query = $oEntityManager->createQuery('
            UPDATE 
                UrlReducerUserBundle:User u
            SET
                u.profil = :profil
            WHERE 
                u.id IN (:id)
            '
        )->setParameters(array(
            'id'     => implode(', ', $aUserIds),
            'profil' => $sProfil
        ))->execute();
    }

    /**
     *
     */
    public function deleteMember($aUserIds) {
        $oEntityManager = $this->getDoctrine()->getEntityManager();
        $query = $oEntityManager->createQuery('
            DELETE
            FROM
                UrlReducerUserBundle:User u
            WHERE 
                u.id IN (:id)
            '
        )->setParameter('id', implode(', ', $aUserIds))
        ->execute();
    }

    /**
     *
     */
    public function constructManageMemberForm($oUser) {
        $aDefaultData = array('message' => 'test');
        $oFormBuilder = $this->createFormBuilder($aDefaultData);

        $oUserRepository = $this->getDoctrine()->getRepository('UrlReducerUserBundle:User');
        $aMembers = $oUserRepository->findAll();

        $aCheckBoxList = array();

        foreach ($aMembers as $oMember) {
            $aLabel = array(
                'pseudo' => $oMember->getPseudo(),
                'nom'    => $oMember->getNom(),
                'prenom' => $oMember->getPrenom()
            );

            if ($oMember->getId() != $oUser->getId()) {
                $aCheckBoxList[$oMember->getId()] = implode(' ', $aLabel);
            }
        }

        $aMemberChoiceListOptions = array(
            'choices'  => $aCheckBoxList,
            'expanded' => true,
            'multiple' => true
        );

        $oFormBuilder->add(
            'user', 
            'choice', 
            $aMemberChoiceListOptions
        );

        $aMemberProfilChoicesOptions = array(
            'choices' => array(
                'member'  => 'Membre',
                'admin'   => 'Administrateur'
             ),
            'empty_value' => 'Choisissez un rôle',
            'required'    => false
        );

        $oFormBuilder->add(
            'profil', 
            'choice', 
            $aMemberProfilChoicesOptions
        );

        return $oFormBuilder->getForm();
    }   
}









