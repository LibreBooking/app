<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Phillip Oertel <me@phillipoertel.com>                       |
// +----------------------------------------------------------------------+
//
// $Id: PHPConstants.php,v 1.3 2005/12/24 02:24:30 aashley Exp $

/**
* Config parser for PHP constant files
*
* @author      Phillip Oertel <me@phillipoertel.com>
* @package     Config
* @version     0.1 (not submitted)
*/

require_once 'Config/Container.php';

class Config_Container_PHPConstants extends Config_Container {

    /**
    * This class options
    * Not used at the moment
    *
    * @var  array
    */
    var $options = array();

    /**
    * Constructor
    *
    * @access public
    * @param    string  $options    (optional)Options to be used by renderer
    */
    function Config_Container_PHPConstants($options = array())
    {
        $this->options = $options;
    } // end constructor

    /**
    * Parses the data of the given configuration file
    *
    * @access public
    * @param string $datasrc    path to the configuration file
    * @param object $obj        reference to a config object
    * @return mixed    returns a PEAR_ERROR, if error occurs or true if ok
    */
    function &parseDatasrc($datasrc, &$obj)
    {
        $return = true;

        if (!file_exists($datasrc)) {
            return PEAR::raiseError("Datasource file does not exist.", null, 
                PEAR_ERROR_RETURN);
        }
        
        $fileContent = file_get_contents($datasrc, true);
        
        if (!$fileContent) {
            return PEAR::raiseError("File '$datasrc' could not be read.", null,
                PEAR_ERROR_RETURN);
        }
        
        $rows = explode("\n", $fileContent);
        for ($i=0, $max=count($rows); $i<$max; $i++) {
            $line = $rows[$i];
    
            //blanks?
                
            // sections
            if (preg_match("/^\/\/\s*$/", $line)) {
                preg_match("/^\/\/\s*(.+)$/", $rows[$i+1], $matches);
                $obj->container->createSection(trim($matches[1]));
                $i += 2;
                continue;
            }
          
            // comments
            if (preg_match("/^\/\/\s*(.+)$/", $line, $matches) || 
                    preg_match("/^#\s*(.+)$/", $line, $matches)) {
                $obj->container->createComment(trim($matches[1]));
                continue;
            }
          
            // directives
            $regex = "/^\s*define\s*\('([A-Z1-9_]+)',\s*'*(.[^\']*)'*\)/";
            preg_match($regex, $line, $matches);
            if (!empty($matches)) {
                $obj->container->createDirective(trim($matches[1]), 
                    trim($matches[2]));
            }
        }
    
        return $return;
        
    } // end func parseDatasrc

    /**
    * Returns a formatted string of the object
    * @param    object  $obj    Container object to be output as string
    * @access   public
    * @return   string
    */
     function toString(&$obj)
     {
         $string = '';

         switch ($obj->type) 
         {
             case 'blank':
                 $string = "\n";
                 break;
                 
             case 'comment':
                 $string = '// '.$obj->content."\n";
                 break;
                 
             case 'directive':
                 $content = $obj->content;
                 // don't quote numeric values, true/false and constants
                 if (!is_numeric($content) && !in_array($content, array('false', 
                            'true')) && !preg_match('/^[A-Z_]+$/', $content)) {
                     $content = "'".$content."'";
                 }
                 $string = 'define(\''.$obj->name.'\', '.$content.');'.chr(10);
                 break;
                 
             case 'section':
                 if (!$obj->isRoot()) {
                     $string  = chr(10);
                     $string .= '//'.chr(10);
                     $string .= '// '.$obj->name.chr(10);
                     $string .= '//'.chr(10);
                 }
                 if (count($obj->children) > 0) {
                     for ($i = 0, $max = count($obj->children); $i < $max; $i++) {
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
    * Writes the configuration to a file
    *
    * @param  mixed  datasrc    info on datasource such as path to the file
    * @param  string configType     (optional)type of configuration
    * @access public
    * @return string
    */
    function writeDatasrc($datasrc, &$obj)
    {
        $fp = @fopen($datasrc, 'w');
        if ($fp) {
            $string  = "<?php";
                $string .= "\n\n";
                $string .= '/**' . chr(10);
                $string .= ' *' . chr(10);
                $string .= ' * AUTOMATICALLY GENERATED CODE - 
                DO NOT EDIT BY HAND' . chr(10);
                $string .= ' *' . chr(10);
                $string .= '**/' . chr(10);
                $string .= $this->toString($obj);
                $string .= "\n?>"; // <? : Fix my syntax coloring

            $len = strlen($string);
            @flock($fp, LOCK_EX);
            @fwrite($fp, $string, $len);
            @flock($fp, LOCK_UN);
            @fclose($fp);
            
            // need an error check here
            
            return true;
        } else {
            return PEAR::raiseError('Cannot open datasource for writing.', 1, 
                PEAR_ERROR_RETURN);
        }
    } // end func writeDatasrc

     
} // end class Config_Container_PHPConstants

?>
