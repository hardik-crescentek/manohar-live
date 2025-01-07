<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* table/structure/primary.twig */
class __TwigTemplate_f85f1211a889fd3370546dfd5f7c1385 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<form action=\"";
        echo PhpMyAdmin\Url::getFromRoute("/table/structure/primary");
        echo "\" method=\"post\">
  ";
        // line 2
        echo PhpMyAdmin\Url::getHiddenInputs(["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null), "selected" => ($context["selected"] ?? null)]);
        echo "

  <fieldset class=\"pma-fieldset confirmation\">
    <legend>
      ";
echo _gettext("Do you really want to execute the following query?");
        // line 7
        echo "    </legend>

    <code>
      ALTER TABLE ";
        // line 10
        echo twig_escape_filter($this->env, PhpMyAdmin\Util::backquote(($context["table"] ?? null)), "html", null, true);
        echo "<br>
      &nbsp;&nbsp;DROP PRIMARY KEY,<br>
      &nbsp;&nbsp;&nbsp;ADD PRIMARY KEY(<br>
      ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["selected"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["field"]) {
            // line 14
            echo "        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo twig_escape_filter($this->env, PhpMyAdmin\Util::backquote($context["field"]), "html", null, true);
            // line 15
            if ( !twig_get_attribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 15)) {
                echo ",";
            }
            echo "<br>
      ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 17
        echo "      &nbsp;&nbsp;&nbsp;);
    </code>
  </fieldset>

  <fieldset class=\"pma-fieldset tblFooters\">
    <input id=\"buttonYes\" class=\"btn btn-secondary\" type=\"submit\" name=\"mult_btn\" value=\"";
echo _gettext("Yes");
        // line 22
        echo "\">
    <input id=\"buttonNo\" class=\"btn btn-secondary\" type=\"submit\" name=\"mult_btn\" value=\"";
echo _gettext("No");
        // line 23
        echo "\">
  </fieldset>
</form>
";
    }

    public function getTemplateName()
    {
        return "table/structure/primary.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  111 => 23,  107 => 22,  99 => 17,  81 => 15,  78 => 14,  61 => 13,  55 => 10,  50 => 7,  42 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/structure/primary.twig", "/home/1098524.cloudwaysapps.com/ytcatbavac/public_html/phpMyAdmin-5.2.1-all-languages/templates/table/structure/primary.twig");
    }
}
