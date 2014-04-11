<?php

namespace UrlReducer\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UrlReducer\CoreBundle\Entity\Url;
use UrlReducer\CoreBundle\Entity\Membre;

class UrlController extends Controller {
    /**
     * 
     */
    public function generateReducedUrlAction() {
        $oRequest = $this->getRequest();

        $oAuthentifier = $this->container->get('url_reducer_core.authentifier');
        $oMember = $oAuthentifier->getMember();

        $oUrl = new Url;

        $oFormBuilder = $this->createFormBuilder($oUrl)
                             ->add('source', 'text')
                             ->add('générer', 'submit');

        $oFormUrl = $oFormBuilder->getForm();

        if ($oRequest->getMethod() == 'POST') {
            $oFormUrl->bind($oRequest);

            if ($oFormUrl->isValid()) {
                $sSourceUrl = $oFormUrl->getData()->getSource();

                $oSession = $this->get('session');
                $iMemberId = $oSession->get('member_id');

                $oDoctrine = $this->getDoctrine();
                $oManager = $oDoctrine->getManager();

                $sShortUrl = $this->reduceUrl($sSourceUrl);

                // we only need to set the short url, the real one was bind through oFormUrl
                $oUrl->setCourte($sShortUrl);
                $oUrl->setAuteur($oMember);

                // $oManager->persist($oUrl);
                $oManager->flush();                     
            }
        }

        $aResponseData = array(
            'form_generate_url' => $oFormUrl->createView(),
            'member'            => $oAuthentifier->getMember()
        );
        
        return $this->render(
            'UrlReducerCoreBundle:Url:home.html.twig', 
            $aResponseData
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
            $oRedirection = $this->redirect($oUrl->getSource());

        } else {
        // url not found, back to index 
            $sUrlToIndex = $this->generateUrl('url_reducer_core_index');
            $oRedirection = $this->redirect($sUrlToIndex);

            // @TODO message flash
        }

        return $oRedirection;
    }

    /**
     * Encrypt url to short url, with salt by user (if he is connected)
     *
     * @param String - the real url
     */
    private function reduceUrl($sUrl) {
        $sCryptedUrl = crypt($sUrl, 'CRYPT_BLOWFISH');
        $sReducedUrl = substr($sCryptedUrl, 0, 8);

        return $sReducedUrl;
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
















