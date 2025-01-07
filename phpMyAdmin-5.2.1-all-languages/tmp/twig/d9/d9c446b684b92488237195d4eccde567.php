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

/* table/search/input_box.twig */
class __TwigTemplate_8bb19861dde751fc7f625987a6d1c62c extends Template
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
        // line 2
        if ((($context["foreigners"] ?? null) && $this->env->getFunction('search_column_in_foreigners')->getCallable()(($context["foreigners"] ?? null), ($context["column_name"] ?? null)))) {
            // line 3
            echo "    ";
            if (twig_test_iterable((($__internal_compile_0 = ($context["foreign_data"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0["disp_row"] ?? null) : null))) {
                // line 4
                echo "        <select name=\"criteriaValues[";
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "]\"
            id=\"";
                // line 5
                echo twig_escape_filter($this->env, ($context["column_id"] ?? null), "html", null, true);
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "\">
            ";
                // line 6
                echo $this->env->getFunction('foreign_dropdown')->getCallable()((($__internal_compile_1 =                 // line 7
($context["foreign_data"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1["disp_row"] ?? null) : null), (($__internal_compile_2 =                 // line 8
($context["foreign_data"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2["foreign_field"] ?? null) : null), (($__internal_compile_3 =                 // line 9
($context["foreign_data"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3["foreign_display"] ?? null) : null), "",                 // line 11
($context["foreign_max_limit"] ?? null));
                // line 12
                echo "
        </select>
    ";
            } elseif (((($__internal_compile_4 =             // line 14
($context["foreign_data"] ?? null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4["foreign_link"] ?? null) : null) == true)) {
                // line 15
                echo "        <input type=\"text\"
            id=\"";
                // line 16
                echo twig_escape_filter($this->env, ($context["column_id"] ?? null), "html", null, true);
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "\"
            name=\"criteriaValues[";
                // line 17
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "]\"
            id=\"field_";
                // line 18
                echo twig_escape_filter($this->env, ($context["column_name_hash"] ?? null), "html", null, true);
                echo "[";
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "]\"
            class=\"textfield\"
            ";
                // line 20
                if (twig_get_attribute($this->env, $this->source, ($context["criteria_values"] ?? null), ($context["column_index"] ?? null), [], "array", true, true, false, 20)) {
                    // line 21
                    echo "                value=\"";
                    echo twig_escape_filter($this->env, (($__internal_compile_5 = ($context["criteria_values"] ?? null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5[($context["column_index"] ?? null)] ?? null) : null), "html", null, true);
                    echo "\"
            ";
                }
                // line 22
                echo ">
        <a class=\"ajax browse_foreign\" href=\"";
                // line 23
                echo PhpMyAdmin\Url::getFromRoute("/browse-foreigners");
                echo "\" data-post=\"";
                // line 24
                echo PhpMyAdmin\Url::getCommon(["db" => ($context["db"] ?? null), "table" => ($context["table"] ?? null)], "", false);
                // line 25
                echo "&amp;field=";
                echo twig_escape_filter($this->env, twig_urlencode_filter(($context["column_name"] ?? null)), "html", null, true);
                echo "&amp;fieldkey=";
                // line 26
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "&amp;fromsearch=1\">
            ";
                // line 27
                echo PhpMyAdmin\Html\Generator::getIcon("b_browse", _gettext("Browse foreign values"));
                echo "
        </a>
    ";
            }
        } elseif (twig_in_filter(        // line 30
($context["column_type"] ?? null), PhpMyAdmin\Utils\Gis::getDataTypes())) {
            // line 31
            echo "    <input type=\"text\"
        name=\"criteriaValues[";
            // line 32
            echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
            echo "]\"
        size=\"40\"
        class=\"textfield\"
        id=\"field_";
            // line 35
            echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
            echo "\">
    ";
            // line 36
            if (($context["in_fbs"] ?? null)) {
                // line 37
                echo "        ";
                $context["edit_str"] = PhpMyAdmin\Html\Generator::getIcon("b_edit", _gettext("Edit/Insert"));
                // line 38
                echo "        <span class=\"open_search_gis_editor\">
            ";
                // line 39
                echo PhpMyAdmin\Html\Generator::linkOrButton(PhpMyAdmin\Url::getFromRoute("/gis-data-editor"), [], ($context["edit_str"] ?? null), [], "_blank");
                echo "
        </span>
    ";
            }
        } elseif (((is_string($__internal_compile_6 =         // line 42
($context["column_type"] ?? null)) && is_string($__internal_compile_7 = "enum") && ('' === $__internal_compile_7 || 0 === strpos($__internal_compile_6, $__internal_compile_7))) || ((is_string($__internal_compile_8 =         // line 43
($context["column_type"] ?? null)) && is_string($__internal_compile_9 = "set") && ('' === $__internal_compile_9 || 0 === strpos($__internal_compile_8, $__internal_compile_9))) && ($context["in_zoom_search_edit"] ?? null)))) {
            // line 44
            echo "    ";
            $context["in_zoom_search_edit"] = false;
            // line 45
            echo "    ";
            $context["value"] = PhpMyAdmin\Util::parseEnumSetValues(($context["column_type"] ?? null));
            // line 46
            echo "    ";
            $context["cnt_value"] = twig_length_filter($this->env, ($context["value"] ?? null));
            // line 47
            echo "    ";
            // line 53
            echo "    ";
            if ((((is_string($__internal_compile_10 = ($context["column_type"] ?? null)) && is_string($__internal_compile_11 = "enum") && ('' === $__internal_compile_11 || 0 === strpos($__internal_compile_10, $__internal_compile_11))) &&  !($context["in_zoom_search_edit"] ?? null)) || ((is_string($__internal_compile_12 =             // line 54
($context["column_type"] ?? null)) && is_string($__internal_compile_13 = "set") && ('' === $__internal_compile_13 || 0 === strpos($__internal_compile_12, $__internal_compile_13))) && ($context["in_zoom_search_edit"] ?? null)))) {
                // line 55
                echo "        <select name=\"criteriaValues[";
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "]\"
            id=\"";
                // line 56
                echo twig_escape_filter($this->env, ($context["column_id"] ?? null), "html", null, true);
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "\">
    ";
            } else {
                // line 58
                echo "        <select name=\"criteriaValues[";
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "]\"
            id=\"";
                // line 59
                echo twig_escape_filter($this->env, ($context["column_id"] ?? null), "html", null, true);
                echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
                echo "\"
            multiple=\"multiple\"
            size=\"";
                // line 61
                echo twig_escape_filter($this->env, min(3, ($context["cnt_value"] ?? null)), "html", null, true);
                echo "\">
    ";
            }
            // line 63
            echo "    ";
            // line 64
            echo "    <option value=\"\"></option>
    ";
            // line 65
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(range(0, (($context["cnt_value"] ?? null) - 1)));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 66
                echo "        ";
                if (((twig_get_attribute($this->env, $this->source, ($context["criteria_values"] ?? null), ($context["column_index"] ?? null), [], "array", true, true, false, 66) && twig_test_iterable((($__internal_compile_14 =                 // line 67
($context["criteria_values"] ?? null)) && is_array($__internal_compile_14) || $__internal_compile_14 instanceof ArrayAccess ? ($__internal_compile_14[($context["column_index"] ?? null)] ?? null) : null))) && twig_in_filter((($__internal_compile_15 =                 // line 68
($context["value"] ?? null)) && is_array($__internal_compile_15) || $__internal_compile_15 instanceof ArrayAccess ? ($__internal_compile_15[$context["i"]] ?? null) : null), (($__internal_compile_16 = ($context["criteria_values"] ?? null)) && is_array($__internal_compile_16) || $__internal_compile_16 instanceof ArrayAccess ? ($__internal_compile_16[($context["column_index"] ?? null)] ?? null) : null)))) {
                    // line 69
                    echo "            <option value=\"";
                    echo (($__internal_compile_17 = ($context["value"] ?? null)) && is_array($__internal_compile_17) || $__internal_compile_17 instanceof ArrayAccess ? ($__internal_compile_17[$context["i"]] ?? null) : null);
                    echo "\" selected>
                ";
                    // line 70
                    echo (($__internal_compile_18 = ($context["value"] ?? null)) && is_array($__internal_compile_18) || $__internal_compile_18 instanceof ArrayAccess ? ($__internal_compile_18[$context["i"]] ?? null) : null);
                    echo "
            </option>
        ";
                } else {
                    // line 73
                    echo "            <option value=\"";
                    echo (($__internal_compile_19 = ($context["value"] ?? null)) && is_array($__internal_compile_19) || $__internal_compile_19 instanceof ArrayAccess ? ($__internal_compile_19[$context["i"]] ?? null) : null);
                    echo "\">
                ";
                    // line 74
                    echo (($__internal_compile_20 = ($context["value"] ?? null)) && is_array($__internal_compile_20) || $__internal_compile_20 instanceof ArrayAccess ? ($__internal_compile_20[$context["i"]] ?? null) : null);
                    echo "
            </option>
        ";
                }
                // line 77
                echo "    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 78
            echo "    </select>
";
        } else {
            // line 80
            echo "    ";
            $context["the_class"] = "textfield";
            // line 81
            echo "    ";
            if ((($context["column_type"] ?? null) == "date")) {
                // line 82
                echo "        ";
                $context["the_class"] = (($context["the_class"] ?? null) . " datefield");
                // line 83
                echo "    ";
            } elseif (((($context["column_type"] ?? null) == "datetime") || (is_string($__internal_compile_21 = ($context["column_type"] ?? null)) && is_string($__internal_compile_22 = "timestamp") && ('' === $__internal_compile_22 || 0 === strpos($__internal_compile_21, $__internal_compile_22))))) {
                // line 84
                echo "        ";
                $context["the_class"] = (($context["the_class"] ?? null) . " datetimefield");
                // line 85
                echo "    ";
            } elseif ((is_string($__internal_compile_23 = ($context["column_type"] ?? null)) && is_string($__internal_compile_24 = "bit") && ('' === $__internal_compile_24 || 0 === strpos($__internal_compile_23, $__internal_compile_24)))) {
                // line 86
                echo "        ";
                $context["the_class"] = (($context["the_class"] ?? null) . " bit");
                // line 87
                echo "    ";
            }
            // line 88
            echo "    <input type=\"text\"
        name=\"criteriaValues[";
            // line 89
            echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
            echo "]\"
        data-type=\"";
            // line 90
            echo twig_escape_filter($this->env, ($context["column_data_type"] ?? null), "html", null, true);
            echo "\"
        ";
            // line 91
            echo ($context["html_attributes"] ?? null);
            echo "
        size=\"40\"
        class=\"";
            // line 93
            echo twig_escape_filter($this->env, ($context["the_class"] ?? null), "html", null, true);
            echo "\"
        id=\"";
            // line 94
            echo twig_escape_filter($this->env, ($context["column_id"] ?? null), "html", null, true);
            echo twig_escape_filter($this->env, ($context["column_index"] ?? null), "html", null, true);
            echo "\"
        ";
            // line 95
            if (twig_get_attribute($this->env, $this->source, ($context["criteria_values"] ?? null), ($context["column_index"] ?? null), [], "array", true, true, false, 95)) {
                // line 96
                echo "           value=\"";
                echo twig_escape_filter($this->env, (($__internal_compile_25 = ($context["criteria_values"] ?? null)) && is_array($__internal_compile_25) || $__internal_compile_25 instanceof ArrayAccess ? ($__internal_compile_25[($context["column_index"] ?? null)] ?? null) : null), "html", null, true);
                echo "\"";
            }
            // line 97
            echo ">
";
        }
    }

    public function getTemplateName()
    {
        return "table/search/input_box.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  289 => 97,  284 => 96,  282 => 95,  277 => 94,  273 => 93,  268 => 91,  264 => 90,  260 => 89,  257 => 88,  254 => 87,  251 => 86,  248 => 85,  245 => 84,  242 => 83,  239 => 82,  236 => 81,  233 => 80,  229 => 78,  223 => 77,  217 => 74,  212 => 73,  206 => 70,  201 => 69,  199 => 68,  198 => 67,  196 => 66,  192 => 65,  189 => 64,  187 => 63,  182 => 61,  176 => 59,  171 => 58,  165 => 56,  160 => 55,  158 => 54,  156 => 53,  154 => 47,  151 => 46,  148 => 45,  145 => 44,  143 => 43,  142 => 42,  136 => 39,  133 => 38,  130 => 37,  128 => 36,  124 => 35,  118 => 32,  115 => 31,  113 => 30,  107 => 27,  103 => 26,  99 => 25,  97 => 24,  94 => 23,  91 => 22,  85 => 21,  83 => 20,  76 => 18,  72 => 17,  67 => 16,  64 => 15,  62 => 14,  58 => 12,  56 => 11,  55 => 9,  54 => 8,  53 => 7,  52 => 6,  47 => 5,  42 => 4,  39 => 3,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "table/search/input_box.twig", "/home/1098524.cloudwaysapps.com/ytcatbavac/public_html/phpMyAdmin-5.2.1-all-languages/templates/table/search/input_box.twig");
    }
}
