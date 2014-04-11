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
        $aResponseData = array();

        $oUrl = new Url;

        $oFormBuilder = $this->createFormBuilder($oUrl)
                             ->add('source', 'text')
                             ->add('générer', 'submit');

        $oFormUrl = $oFormBuilder->getForm();

        if ($oRequest->getMethod() == 'POST') {
            $oFormUrl->bind($oRequest);

            if ($oFormUrl->isValid()) {
                // default: no owner for that url
                $oMember = null;

                $oPost = $oRequest->request;
                $sSourceUrl = $oPost->get('source');

                $oSession = $this->get('session');
                $iMemberId = $oSession->get('member_id');

                $oDoctrine = $this->getDoctrine();
                $oManager = $oDoctrine->getManager();

                if ($iMemberId != null) {
                    $oMemberRepository = $oDoctrine->getRepository('UrlReducerCoreBundle:Membre');
                    $oMember = $oMemberRepository->find($iMemberId);
                }

                $sShortUrl = $this->getReducedUrl($sSourceUrl);
                $aResponseData['short_url'] = $sShortUrl;

                // we only need to set the short url, the real one was bind through oFormUrl
                $oUrl->setCourte($sShortUrl);

                $oManager->persist($oUrl);
                $oManager->flush();                     
            }
        }

        $aResponseData['form_url'] = $oFormUrl->createView();
        
        return $this->render(
            'UrlReducerCoreBundle:Url:form_url.html.twig', 
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
     * @param String - the real 
     */
    private function getReducedUrl($sUrl) {
        $sCryptedUrl = crypt($sUrl, 'CRYPT_BLOWFISH');
        $sReducedUrl = substr($sCryptedUrl, 0, 8);

        return $sReducedUrl;
    }
}
















