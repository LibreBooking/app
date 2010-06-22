<?php
/**
* This File is part of the SmartLoader
* 
* @author Maarten Manders (mandersm@student.ethz.ch)
* @copyright Copyright 2005, Maarten Manders
* @link http://www.maartenmanders.org
* @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
* @package SmartLoader
*/
/**
* PHP Autoload Hook
* 
* Gets called, when an undefined class is being instanciated
*
* @package SmartLoader
* @param_string string class name
*/
function __autoload($class_name) {
	static $ldr = null;
	
	/* initializing loader */
	if(!$ldr) {
		$ldr = new SmartLoader();
		$ldr->setCacheFilename(dirname(__FILE__) . '/../cache/smartloader_cache.php');
		$ldr->addDir('.');
		//$ldr->addDir(dirname(__FILE__));
		$ldr->setClassFileEndings(array('.php'));
		$ldr->setIgnoreHiddenFiles(true);
	}
	
	/* load the class or trigger some fatal error on failure */
	if(!$ldr->loadClass($class_name)) {
		trigger_error("SmartLoader: Cannot load class '".$class_name."'", E_USER_ERROR);
	}
}

	/**
	* SmartLoader Class
	*
	* Singleton. Manages class/interface retrieval, caching and inclusion.
	*
	* @package SmartLoader
	* @author Maarten Manders (mandersm@student.ethz.ch)
	* @example index.php
	* @see SmartLoader::instance()
	* @see SmartLoader::addDir()
	* @see SmartLoader::loadClass()
	*/
	class SmartLoader
	{
		/**
		* Class Directories
		* 
		* Holds the directories SmartLoader scans for class/interface definitions
		* 
		* @var array
		* @access private
		*/
		private $classDirectories = array();
		
		/**
		* Cache File Path
		* 
		* Holds the filename of the generated cache file.
		* 
		* @var string
		* @access private
		*/
		private $cacheFilename = 'smartloader_cache.php';
		
		/**
		* Class Index
		* 
		* Holds an associative array (class name => class file) when scanning.
		* 
		* @var array
		* @access private
		*/
		private $classIndex = array();
		
		/**
		* Class File Endings
		* 
		* Files with these endings will be parsed by the class/interface scanner.
		* 
		* @var array
		* @access private
		*/
		private $classFileEndings = array();
		
		/**
		* Follow SymLinks
		* 
		* Should SmartLoader follow SymLinks when searching class dirs?
		* 
		* @var boolean
		* @access private
		*/
		private $followSymlinks = false;
		
		/**
		* Ignore hidden files
		* 
		* Should SmartLoader ignore hidden files?
		* 
		* @access private
		*/
		private $ignoreHiddenFiles = true;
		
		/**
		* Constructor
		* 
		* Initialize SmartLoader
		*
		* @access public
		*/
		public function __construct() {
			/* do something smart here */
		}
		
		/**
		* Set Cache File Path
		* 
		* Define a path to store the cache file. Make sure PHP has permission read/write on it.
		*
		* @access public
		* @param string string Cache File Path
		*/
		public function setCacheFilename($cacheFilename) {
			$this->cacheFilename = $cacheFilename;
		}
		
		/**
		* Set Class File Endings
		* 
		* Define which file endings will be considered by the class/interface scanner
		* An empty array will let the scanner parse any file type.
		*
		* @access public
		* @param array Endings
		*/
		public function setClassFileEndings($classFileEndings) {
			$this->classFileEndings = $classFileEndings;
		}
		
		/**
		* Set Follow Symlinks Flag
		* 
		* Define whether SmartLoader should follow symlinks in when searching the class directory
		*
		* @access public
		* @param boolean follow symlinks
		*/
		public function setfollowSymlinks($value) {
			$this->followSymlinks = $value;
		}
		
		/**
		* Set ignore hidden files
		* 
		* Define whether SmartLoader should ignore hidden files
		*
		* @access public
		* @param boolean value, true to ignore
		*/
		public function setIgnoreHiddenFiles($value) {
			$this->ignoreHiddenFiles = $value;
		}
		
		/**
		* Add a directory to retrieve classes/interfaces from
		* 
		* This function adds a directory to retrieve class/interface definitions from.
		*
		* @access public
		* @param string $directory_path
		*/
		public function addDir($directory_path) {
			// add trailing slash
			if(substr($directory_path, -1) != '/') {
				$directory_path .= '/';
			}
			if(!in_array($directory_path, $this->classDirectories)) {
				$this->classDirectories[] = $directory_path;
			}
		}
		
		/**
		* Load a Class
		* 
		* Loads a class by its name
		* - If the matching class definition file can't be found in the cache,
		* 	it will try once again with $retry = true.
		* - When retrying, the cached index is invalidated, regenerated and re-included.
		*
		* @access public
		* @param string $class_name
		* @param boolean $retry used for recursion
		* @return boolean Success
		*/
		public function loadClass($class_name, $retry = false) {
			/* Is the class already defined? (can be omitted in combination with __autoload) */
			if(class_exists($class_name)) {
				return true;
			}
			
			/* Is our cache outdated or not available? Recreate it! */
			if($retry || !is_readable($this->cacheFilename)) {
				$this->createCache();
			}
			
			/* Include the cache file or raise error if something's wrong with the cache */
			if(!include($this->cacheFilename)) {
				trigger_error("SmartLoader: Cannot include cache file from '".$this->cacheFilename."'", E_USER_ERROR);
			}
			
			/* Include requested file. Return on success */
			if(isset($GLOBALS['smartloader_classes'][$class_name]) && is_readable($GLOBALS['smartloader_classes'][$class_name])) {
				if(include($GLOBALS['smartloader_classes'][$class_name])) {
					return true;
				}
			} 
			
			/* On failure retry recursively, but only once. */
			if($retry) {
				return false;
			} else {
				return $this->loadClass($class_name, true);
			}
		}
		
		/**
		* Create Cache
		* 
		* - Scans the class dirs for class/interface definitions and 
		* 	creates an associative array (class name => class file) 
		* - Generates the array in PHP code and saves it as cache file
		*
		* @access private
		* @param param_type $param_name
		*/
		private function createCache() {
			/* Create class list */
			foreach($this->classDirectories as $dir) {
				$this->parseDir($dir);
			}
			
			/* Generate php cache file */
			$cache_content = "<?php\n\t// this is a automatically generated cache file.\n"
				."\t// it serves as 'class name' / 'class file' association index for the SmartLoader\n";
			foreach($this->classIndex as $class_name => $class_file) {
				$cache_content .= "\t\$GLOBALS['smartloader_classes']['".$class_name."'] = '".$class_file."';\n";
			}
			$cache_content .= "?>";
			if($cacheFilename_handle = fopen($this->cacheFilename, "w+")) {
				fwrite($cacheFilename_handle, $cache_content);
				/* Allow ftp users to access/modify/delete cache file, suppress chmod errors here */
				@chmod($this->cacheFilename, 0664);
			}
		}
		
		/**
		* Parse Directory
		* 
		* Parses a directory for class/interface definitions. Saves found definitions
		* in $classIndex. Needless to say: Mind recursion cycles when using symlinks.
		* TODO: Clean up this method; use SPL, if suitable.
		*
		* @access private
		* @param string $directory_path
		* @return boolean Success
		*/
		private function parseDir($directory_path) {
			if(is_dir($directory_path)) {
				if($dh = opendir($directory_path)) {
					while(($file = readdir($dh)) !== false) {
						$file_path = $directory_path.$file;
						if(!$this->ignoreHiddenFiles || $file{0} != '.') {
							switch(filetype($file_path))
							{
								case 'dir':
									if($file != "." && $file != "..") {
										/* parse on recursively */
										$this->parseDir($file_path.'/');
									}
									break;
								case 'link':
									if($this->followSymlinks) {
										/* follow link, parse on recursively */
										$this->parseDir($file_path.'/');
									}
									break;
								case 'file':
									/* a non-empty endings array implies an ending check
									 * TODO: Write a more sophisticated suffix check. */
									if(!sizeof($this->classFileEndings) || in_array(substr($file, strrpos($file, '.')), $this->classFileEndings)) {
										$parts = explode('.', $file);
										$this->classIndex[$parts[0]] = $file_path;
										//if($php_file = fopen($file_path, "r")) {
//											if($buf = fread($php_file, filesize($file_path))) {
//												if(preg_match_all("%(interface|class)\s+(\w+)\s+(extends\s+(\w+)\s+)?(implements\s+\w+\s*(,\s*\w+\s*)*)?{%", $buf, $result = array())) {
//													foreach($result[2] as $class_name) {
//														$this->classIndex[$class_name] = $file_path;
//													}
//												}
//											}
//										}
									}
									break;
							}
						}
					}
					return true;
				}
			}
			return false;
		}
	}
?>