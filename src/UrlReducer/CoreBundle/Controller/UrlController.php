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
        $sShortUrl = '';

        try {
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

                    // we only need to set the short url, the real one was bind through oFormUrl
                    $oUrl->setCourte($sShortUrl);

                    $oManager->persist($oUrl);
                    $oManager->flush();                     
                }
            }
        } catch (FormException $e) {
            // @TODO rediriger avec erreur
        }
        
        return $this->render(
            'UrlReducerCoreBundle:Url:form_url.html.twig', 
            array(
                'form_url'  => $oFormUrl->createView(),
                'short_url' => $sShortUrl
            )
        );
    }

    /**
     *
     */
    public function redirectFromShortToSourceUrlAction($sUrl) {

    }

    /**
     *
     */
    private function getReducedUrl($sUrl) {
        $sCryptedUrl = crypt($sUrl, 'CRYPT_BLOWFISH');
        $sReducedUrl = substr($sCryptedUrl, 0, 8);

        return $sReducedUrl;
    }
}
















