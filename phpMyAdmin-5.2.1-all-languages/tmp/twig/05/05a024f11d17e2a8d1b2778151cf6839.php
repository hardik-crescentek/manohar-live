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

/* table/index_rename_form.twig */
class __TwigTemplate_32e002813d2be3159ed6bfdb8c9db587 extends Template
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
        echo PhpMyAdmin\Url::getFromRoute("/table/indexes/rename");
        echo "\" method=\"post\" name=\"index_frm\" id=\"index_frm\" class=\"ajax\">

  ";
        // line 3
        echo PhpMyAdmin\Url::getHiddenInputs(($context["form_params"] ?? null));
        echo "

  <fieldset class=\"pma-fieldset\" id=\"index_edit_fields\">
    <div class=\"index_info\">
      <div>
          <div class=\"label\">
              <strong>
                  <label for=\"input_index_name\">
                      ";
echo _gettext("Index name:");
        // line 12
        echo "                      ";
        echo PhpMyAdmin\Html\Generator::showHint(_gettext("\"PRIMARY\" <b>must</b> be the name of and <b>only of</b> a primary key!"));
        echo "
                  </label>
              </strong>
          </div>

          <input type=\"text\"
              name=\"index[Key_name]\"
              id=\"input_index_name\"
              size=\"25\"
              maxlength=\"64\"
              value=\"";
        // line 22
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["index"] ?? null), "getName", [], "method", false, false, false, 22), "html", null, true);
        echo "\"
              onfocus=\"this.select()\">
      </div>
    </div>
  </fieldset>
  <fieldset class=\"pma-fieldset tblFooters\">
    <button class=\"btn btn-secondary\" type=\"submit\" id=\"preview_index_frm\">";
echo _gettext("Preview SQL");
        // line 28
        echo "</button>
  </fieldset>
</form>
";
    }

    public function getTemplateName()
    {
        return "table/index_rename_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  79 => 28,  69 => 22,  55 => 12,  43 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/index_rename_form.twig", "/home/1098524.cloudwaysapps.com/ytcatbavac/public_html/phpMyAdmin-5.2.1-all-languages/templates/table/index_rename_form.twig");
    }
}
