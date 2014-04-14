<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;

class UrlControllerException extends \Exception {};

class UrlController extends Controller {
    /**
     * 
     */
    public function generateReducedUrlAction(Request $oRequest) {
        $aRenderingData = array();

        $oAuthentifier = $this->container->get('url_reducer_core.authentifier');
        $oUser = $oAuthentifier->getUser();

        $oUrl = new Url;

        $oFormBuilder = $this->createFormBuilder($oUrl)
                             ->add('source', 'text')
                             ->add('générer', 'submit');

        $oFormUrl = $oFormBuilder->getForm();
        $oFormUrl->handleRequest($oRequest);

        if ($oFormUrl->isValid()) {
            try {
                $sSourceUrl = $oFormUrl->getData()->getSource();
                $oDoctrine = $this->getDoctrine();

                // try to retrieve an existing reduced url
                $oUrlRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Url');
                $aSearchCriteria = array('source' => $sSourceUrl);

                if ($oUser != null) {
                    $aSearchCriteria['auteur'] = $oUser->getId();
                }

                $oExistingUrl = $oUrlRepository->findOneBy($aSearchCriteria);

                if ($oExistingUrl == null) {
                // if no url with that source, let create one
                    throw new UrlControllerException;
                } else if (
                    $oUser != null 
                    && $oExistingUrl->getAuteur()->getId() != $oUser->getId()
                ) {
                // a user must have his own reduced urls, so let create one
                    throw new UrlControllerException;
                } else {
                // just display the existing reduced one
                    $aRenderingData['reduced_url'] = $this->getReducedUrl($oExistingUrl->getCourte());
                }
            } catch (UrlControllerException $e) {
                $oManager = $oDoctrine->getManager();
                $sEncryptedUrl = $this->reduceUrl($sSourceUrl, $oUser);

                // we only need to set the short url, the real one was bind through oFormUrl
                $oUrl->setCourte($sEncryptedUrl);
                $oUrl->setAuteur($oUser);

                $aRenderingData['reduced_url'] = $this->getReducedUrl($sEncryptedUrl);

                $oManager->persist($oUrl);
                $oManager->flush();    
            }
        }

        $aRenderingData['form_generate_url'] = $oFormUrl->createView();
        
        return $this->render(
            'UrlReducerCoreBundle:Url:home.html.twig', 
            $aRenderingData
        );
    }

    /**
     *
     */
    public function goToSourceUrlAction($sUrl) {
        // we try to retrieve a real url from database
        $oDoctrine = $this->getDoctrine();
        $oManager = $oDoctrine->getManager();

        $oUrlRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Url');
        $oUrl = $oUrlRepository->findOneByCourte($sUrl);
        
        if ($oUrl != null) {
        // url found, redirection...
            $oResponse = $this->redirect($oUrl->getSource());

        } else {
        // url not found, back to index 
            $sUrlToIndex = $this->generateUrl('url_reducer_core_url_generate');
            $oResponse = $this->redirect($sUrlToIndex);

            $this->get('session')
                 ->getFlashBag()
                 ->add('url error', "L'url demandée n'a pas été trouvée");
        }

        return $oResponse;
    }

    /**
     * Encrypt url to short url, with salt by user_id (if he is connected)
     *
     * @param String - the real url
     */
    private function reduceUrl($sUrl, $oUser = null) {
        if ($oUser != null) {
            $sHashedUrl = sha1($oUser->getId() . $sUrl);
        } else {
            $sHashedUrl = sha1($sUrl);
        }

        return substr($sHashedUrl, 0, 8);
    }

    /**
     * Get the full-reduced url (with host part) 
     *
     * @param String - the encrypted url
     */
    private function getReducedUrl($sShortUrl) {
        $oServerData = $this->getRequest()->server;
        return $oServerData->get('HTTP_REFERER') . $sShortUrl;
    }
}
















