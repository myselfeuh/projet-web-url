<?php

/* UrlShortenerTestBundle:Default:test.html.twig */
class __TwigTemplate_de7d82fceaaaf7e08433def2bf29d433d7ac74304ac9c0a81383506617b0cf83 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo "
<html>
  <body>
    Test ";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["nom_test"]) ? $context["nom_test"] : $this->getContext($context, "nom_test")), "html", null, true);
        echo "!
  </body>
</html>";
    }

    public function getTemplateName()
    {
        return "UrlShortenerTestBundle:Default:test.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 5,  19 => 2,);
    }
}
