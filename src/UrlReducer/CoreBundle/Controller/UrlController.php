<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\Membre;

use Symfony\Component\HttpFoundation\Request;

class UrlController extends Controller {
    /**
     * 
     */
    public function generateReducedUrlAction(Request $oRequest) {
        $aRenderingData = array();

        $oAuthentifier = $this->container->get('url_reducer_core.authentifier');
        $oMember = $oAuthentifier->getMember();

        $oUrl = new Url;

        $oFormBuilder = $this->createFormBuilder($oUrl)
                             ->add('source', 'text')
                             ->add('générer', 'submit');

        $oFormUrl = $oFormBuilder->getForm();

        $oFormUrl->handleRequest($oRequest);

        if ($oFormUrl->isValid()) {
            $sSourceUrl = $oFormUrl->getData()->getSource();

            $oSession = $this->get('session');
            $iMemberId = $oSession->get('member_id');

            $oDoctrine = $this->getDoctrine();
            $oManager = $oDoctrine->getManager();

            $sEncryptedUrl = $this->reduceUrl($sSourceUrl, $oMember);

            // we only need to set the short url, the real one was bind through oFormUrl
            $oUrl->setCourte($sEncryptedUrl);
            $oUrl->setAuteur($oMember);

            $aRenderingData['reduced_url'] = $this->getReducedUrl($sEncryptedUrl);

            $oManager->persist($oUrl);
            $oManager->flush();                     
        }

        $aRenderingData['form_generate_url'] = $oFormUrl->createView();
        $aRenderingData['member_menu']       = $oAuthentifier->generateMemberMenuComponents();
        
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

            $this->get('session')->getFlashBag()->add('url error', "L'url demandée n'a pas été trouvée");
        }

        return $oResponse;
    }

    /**
     * Encrypt url to short url, with salt by user_id (if he is connected)
     *
     * @param String - the real url
     */
    private function reduceUrl($sUrl, $oMember = null) {
        if ($oMember != null) {
            $sHashedUrl = sha1($oMember->getId() . $sUrl);
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
















