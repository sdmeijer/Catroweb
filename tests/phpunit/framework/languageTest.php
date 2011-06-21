<?php
/*    Catroid: An on-device graphical programming language for Android devices
 *    Copyright (C) 2010-2011 The Catroid Team
 *    (<http://code.google.com/p/catroid/wiki/Credits>)
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Affero General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once('frameworkTestsBootstrap.php');

class languageTest extends PHPUnit_Framework_TestCase {
  protected $file_listing;
  protected $whitelist;
  protected $whitelist_folders;

  protected function setUp() {
    $this->file_listing = array();
    $this->whitelist = array("aliveCheckerDB.php", "aliveCheckerHost.php");
    $this->whitelist_folders = array();
    $this->walkThroughDirectory(CORE_BASE_PATH.'modules/');
  }
  
  protected function tearDown() {
    $testdata = dirname(__FILE__).'/testdata/languageTestData/';
    $runtimeFolder1 = $testdata.'testOutput1/';
    $runtimeFolder2 = $testdata.'testOutput2/';
    removeDir($runtimeFolder1);
    removeDir($runtimeFolder2);
  }

  public function testLanguageFolders() {
    foreach($this->file_listing as $module=>$files) {
      $folder = CORE_BASE_PATH.LANGUAGE_PATH.'/'.SITE_DEFAULT_LANGUAGE.'/'.$module;
      if(!is_dir($folder)) {
        print "\nLanguage folder missing:\n$folder\n";
      }
      $this->assertTrue(is_dir($folder));
    }
  }

  public function testErrorXmlFiles() {
    $errorDevFile = CORE_BASE_PATH.LANGUAGE_PATH.SITE_DEFAULT_LANGUAGE.'/errors/'.DEFAULT_DEV_ERRORS_FILE;
    $errorPubFile = CORE_BASE_PATH.LANGUAGE_PATH.SITE_DEFAULT_LANGUAGE.'/errors/'.DEFAULT_PUB_ERRORS_FILE;
    if(!file_exists($errorDevFile)) {
      print "\nError XML File missing:\n$errorDevFile\n";
    }
    if(!file_exists($errorPubFile)) {
      print "\nError XML File missing:\n$errorPubFile\n";
    }
    $this->assertTrue(file_exists($errorDevFile));
    $this->assertTrue(file_exists($errorPubFile));

    $errorsDevXml = simplexml_load_file($errorDevFile);
    $errorsPubXml = simplexml_load_file($errorPubFile);
    if(count($errorsDevXml->children()) != count($errorsPubXml->children())) {
      print "\nError XMLs for DEV and PUB differ in ErrorType Nodes!";
    }
    $this->assertEquals(count($errorsDevXml->children()), count($errorsPubXml->children()));

    $errorsDevNodeCount = array();
    foreach($errorsDevXml->children() as $error_type) {
      $errorsDevNodeCount[strval($error_type->getName())] = count($error_type->children());
    }
    foreach($errorsPubXml->children() as $error_type) {
      if($errorsDevNodeCount[strval($error_type->getName())] != count($error_type->children())) {
        print "\nErrorTypeNode ".strval($error_type->getName()).": children Nodes differ in number!";
      }
      $this->assertEquals($errorsDevNodeCount[strval($error_type->getName())], count($error_type->children()));
    }
  }

  public function testTemplateXmlFiles() {
    foreach($this->file_listing as $module=>$files) {
      $template = CORE_BASE_PATH.LANGUAGE_PATH.SITE_DEFAULT_LANGUAGE.'/'.$module.'/'.DEFAULT_TEMPLATE_LANGUAGE_FILE;
      if(!file_exists($template)) {
        print "\nTemplate XML File missing:\n$template\n";
      }
      $this->assertTrue(file_exists($template));

      $xml = simplexml_load_file($template);
      foreach($xml->children() as $string) {
        $attributes = $string->attributes();
        if($string->getName() && $attributes['name']) {
          $name = strval($attributes['name']);
          if(strcmp(substr($name, 0, strpos($name, '_')+1), 'template_') != 0) {
            print "\n'template_' - prefix missing in stringname '$name' in file $template.\n";
            print "change the stringname to 'template_$name' instead!\n";
          }
          $this->assertEquals(0, strcmp(substr($name, 0, strpos($name, '_')+1), 'template_'));
        }
      }
    }
  }

  public function testLanguageXmlFiles() {
    foreach($this->file_listing as $module=>$files) {
      foreach($files as $file) {
        $class = substr($file, 0, strpos($file, '.'));
        $languageFile = CORE_BASE_PATH.LANGUAGE_PATH.SITE_DEFAULT_LANGUAGE.'/'.$module.'/'.$class.'.xml';
        if(!file_exists($languageFile)) {
          print "\nLanguage XML File missing:\n$languageFile\n";
        }
        $this->assertTrue(file_exists($languageFile));
      }
    }
  }
  
  public function testLanguageScripts() {
    require_once CORE_BASE_PATH.'pootle/generateStringsXmlFunctions.php';
    require_once CORE_BASE_PATH.'pootle/generatePootleFileFunctions.php';
    require_once CORE_BASE_PATH.'pootle/generateLanguagePackFunctions.php';
    $testdata = dirname(__FILE__).'/testdata/languageTestData/';
    $runtimeFolder1 = $testdata.'testOutput1/';
    $runtimeFolder2 = $testdata.'testOutput2/';
    removeDir($runtimeFolder1);
    removeDir($runtimeFolder2);
    generateStringsXml($testdata, $runtimeFolder1);
    generatePootleFile($runtimeFolder1);
    generateLanguagePack(SITE_DEFAULT_LANGUAGE, $runtimeFolder1, $runtimeFolder1.'include/xml/lang/');
    copyDir($testdata.'modules/', $runtimeFolder1.'modules/');
    generateStringsXml($runtimeFolder1, $runtimeFolder2);
    generatePootleFile($runtimeFolder2);
    $stringsXmlFile1 = $runtimeFolder1.SITE_DEFAULT_LANGUAGE.'/strings.xml';
    $stringsXmlFile2 = $runtimeFolder2.SITE_DEFAULT_LANGUAGE.'/strings.xml';
    $pootleFile1 = $runtimeFolder1.SITE_DEFAULT_LANGUAGE.'/catweb.pot';
    $pootleFile2 = $runtimeFolder2.SITE_DEFAULT_LANGUAGE.'/catweb.pot';
    $this->assertEquals(md5_file($stringsXmlFile1), md5_file($stringsXmlFile2));
    $this->assertEquals(md5_file($pootleFile1), md5_file($pootleFile2));
    removeDir($runtimeFolder1);
    removeDir($runtimeFolder2);
  }

  public function walkThroughDirectory($directory, $module = null) {
    if(is_dir($directory)) {
      if($directory_handler = opendir($directory)) {
        while(($file = readdir($directory_handler)) !== false) {
          if($file != "." && $file != "..") {
            if(is_dir($directory.$file)) {
              if(!in_array($file, $this->whitelist_folders)) {
                if(!isset($this->file_listing[$file])) {
                  $this->file_listing[$file] = array();
                }
                $this->walkThroughDirectory($directory.$file . "/", $file);
              }
            }

            if(!in_array($file, $this->whitelist)) {
              if($module)
              array_push($this->file_listing[$module], $file);
            }
          }
        }
        closedir($directory_handler);
      }
    }
  }

}
?>
