<?php
/**
 * Part of the PEAR Config package
 *
 * PHP Version 4
 *
 * @category Configuration
 * @package  Config
 * @author   Bertrand Mansion <bmansion@mamasam.com>
 * @license  http://www.php.net/license PHP License
 * @link     http://pear.php.net/package/Config
 */

/**
 * Config parser for PHP .ini files
 * Faster because it uses parse_ini_file() but get rid of comments,
 * quotes, types and converts On, Off, True, False, Yes, No to 0 and 1.
 *
 * Empty lines and comments are not preserved.
 *
 * @category Configuration
 * @package  Config
 * @author   Bertrand Mansion <bmansion@mamasam.com>
 * @license  http://www.php.net/license PHP License
 * @link     http://pear.php.net/package/Config
 */
class Config_Container_IniFile
{

    /**
     * This class options
     * Not used at the moment
     *
     * @var array
    */
    var $options = array();

    /**
     * Constructor
     *
     * @param string $options (optional)Options to be used by renderer
     *
     * @access public
     */
    function Config_Container_IniFile($options = array())
    {
        $this->options = $options;
    } // end constructor

    /**
     * Parses the data of the given configuration file
     *
     * @param string $datasrc path to the configuration file
     * @param object &$obj    reference to a config object
     *
     * @return mixed Returns a PEAR_ERROR, if error occurs or true if ok
     *
     * @access public
     */
    function &parseDatasrc($datasrc, &$obj)
    {
        $return = true;
        if (!file_exists($datasrc)) {
            return PEAR::raiseError(
                "Datasource file does not exist.",
                null, PEAR_ERROR_RETURN
            );
        }
        $currentSection =& $obj->container;
        $confArray = parse_ini_file($datasrc, true);
        if (!$confArray) {
            return PEAR::raiseError(
                "File '$datasrc' does not contain configuration data.",
                null, PEAR_ERROR_RETURN
            );
        }
        foreach ($confArray as $key => $value) {
            if (is_array($value)) {
                $currentSection =& $obj->container->createSection($key);
                foreach ($value as $directive => $content) {
                    // try to split the value if comma found
                    if (!is_array($content) && strpos($content, '"') === false) {
                        $values = preg_split('/\s*,\s+/', $content);
                        if (count($values) > 1) {
                            foreach ($values as $k => $v) {
                                $currentSection->createDirective($directive, $v);
                            }
                        } else {
                            $currentSection->createDirective($directive, $content);
                        }
                    } else {
                        $currentSection->createDirective($directive, $content);
                    }
                }
            } else {
                $currentSection->createDirective($key, $value);
            }
        }
        return $return;
    } // end func parseDatasrc

    /**
     * Returns a formatted string of the object
     *
     * @param object &$obj Container object to be output as string
     *
     * @return string
     *
     * @access public
     */
    function toString(&$obj)
    {
        static $childrenCount, $commaString;

        if (!isset($string)) {
            $string = '';
        }
        switch ($obj->type) {
        case 'blank':
            $string = "\n";
            break;
        case 'comment':
            $string = ';'.$obj->content."\n";
            break;
        case 'directive':
            $count = $obj->parent->countChildren('directive', $obj->name);
            $content = $obj->content;
            if (!is_array($content)) {
                $content = $this->contentToString($content);
                if ($count > 1) {
                    // multiple values for a directive are separated by a comma
                    if (isset($childrenCount[$obj->name])) {
                        $childrenCount[$obj->name]++;
                    } else {
                        $childrenCount[$obj->name] = 0;
                        $commaString[$obj->name] = $obj->name.'=';
                    }
                    if ($childrenCount[$obj->name] == $count-1) {
                        // Clean the static for future calls to toString
                        $string .= $commaString[$obj->name].$content."\n";
                        unset($childrenCount[$obj->name]);
                        unset($commaString[$obj->name]);
                    } else {
                        $commaString[$obj->name] .= $content.', ';
                    }
                } else {
                    $string = $obj->name.'='.$content."\n";
                }
            } else {
                //array
                $string = '';
                $n = 0;
                foreach ($content as $contentKey => $contentValue) {
                    if (is_integer($contentKey) && $contentKey == $n) {
                        $stringKey = '';
                        ++$n;
                    } else {
                        $stringKey = $contentKey;
                    }
                    $string .= $obj->name . '[' . $stringKey . ']='
                        . $this->contentToString($contentValue) . "\n";
                }
            }
            break;
        case 'section':
            if (!$obj->isRoot()) {
                $string = '['.$obj->name."]\n";
            }
            if (count($obj->children) > 0) {
                for ($i = 0; $i < count($obj->children); $i++) {
                    $string .= $this->toString($obj->getChild($i));
                }
            }
            break;
        default:
            $string = '';
        }
        return $string;
    } // end func toString



    /**
     * Converts a given content variable to a string that can
     * be used as value in a ini file
     *
     * @param mixed $content Value
     *
     * @return string $content String to be used as ini value
     */
    function contentToString($content)
    {
        if ($content === false) {
            $content = '0';
        } else if ($content === true) {
            $content = '1';
        } else if (strlen(trim($content)) < strlen($content)
            || strpos($content, ',') !== false
            || strpos($content, ';') !== false
            || strpos($content, '=') !== false
            || strpos($content, '"') !== false
            || strpos($content, '%') !== false
            || strpos($content, '~') !== false
            || strpos($content, '!') !== false
            || strpos($content, '|') !== false
            || strpos($content, '&') !== false
            || strpos($content, '(') !== false
            || strpos($content, ')') !== false
            || $content === 'none'
        ) {
            $content = '"'.addslashes($content).'"';          
        }
        return $content;
    }

} // end class Config_Container_IniFile
?>
