<?php
/**
 * Catroid: An on-device visual programming system for Android devices
 * Copyright (C) 2010-2013 The Catrobat Team
 * (<http://developer.catrobat.org/credits>)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * An additional term exception under section 7 of the GNU Affero
 * General Public License, version 3, is available at
 * http://developer.catrobat.org/license_additional_term
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */


	class CoreClientDetection {
		private $_useragent = '';
		private $_is_mobile = false;
		private $_browser_language = '';
		
		public function CoreClientDetection($useragent="") {
			$this->reset();
			if( $useragent != "" ) {
				$this->setUserAgent($useragent);
				//$this->setMobile($this->isMobileBrowser($useragent));
			} else {
				$this->setUserAgent('');
				//$this->setMobile(isMobileBrowser(getUserAgent()));
			}
			$this->setBrowserLanguage();
		}

		/**
		* Reset all properties
		*/
		public function reset() {
			$this->_useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
			$this->_is_mobile = false;
			$this->_is_robot = false;
			$this->_browser_language = '';
		}

		public function getBrowserLanguage() { 
		  return $this->_browser_language; 
		}
		
		public function getUserAgent() {
		  return $this->_useragent;
		}
		
		public function isMobile() { 
		  return $this->_is_mobile; 
		}
		
		public function isRobot() {
		  return $this->_is_robot;
		}
		public function isBrowser() {
		  return $this->_is_robot = false;
		}
		
    protected function setUseragent($useragent) {
      if ($useragent)
        $this->_useragent = $useragent;
      else
        $this->_useragent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
      $this->setMobile($this->isMobileBrowser($this->_useragent));
      $this->setRobot($this->isRobotBrowser($this->_useragent));
    }

    protected function setMobile($value=true) { 
       $this->_is_mobile = $value;
	  }
	  
	  protected function setRobot($value=true) {
	    $this->_is_robot = $value;
	  }
	   
		private function setBrowserLanguage() {
		  if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		    $this->_browser_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		  } else {
		    $this->_browser_language = SITE_DEFAULT_LANGUAGE;
		  }
		}
		
		// regular Expression - can be retrieved in admin-mode from http://detectmobilebrowsers.com/download/php
		public function isMobileBrowser($useragent) {
		    // <isMobile>
				if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
				// </isMobile>
		      return true;
		    else
		      return false;
		}
		
		/**
		 * Determine if the browser is the GoogleBot or not (last updated 1.7)
		 * @return boolean True if the browser is the GoogletBot otherwise false
		 */
		public function isRobotBrowser() {
		  if( stripos($this->_useragent,'googlebot') !== false ) {
		    $aresult = explode('/',stristr($this->_useragent,'googlebot'));
		    $aversion = explode(' ',$aresult[1]);
		    return true;
		  }
		  
		  if( stripos($this->_useragent,"msnbot") !== false ) {
		    $aresult = explode("/",stristr($this->_useragent,"msnbot"));
		    $aversion = explode(" ",$aresult[1]);
		    return true;
		  } 
		  
		  if ( stripos($this->_useragent,'W3C-checklink') !== false ) {
		    $aresult = explode('/',stristr($this->_useragent,'W3C-checklink'));
		    $aversion = explode(' ',$aresult[1]);
		    return false;
		  }
		  
		  if( stripos($this->_useragent,'W3C_Validator') !== false ) {
		    // Some of the Validator versions do not delineate w/ a slash - add it back in
		    $ua = str_replace("W3C_Validator ", "W3C_Validator/", $this->_useragent);
		    $aresult = explode('/',stristr($ua,'W3C_Validator'));
		    $aversion = explode(' ',$aresult[1]);
        return false;
		  } 
		  
		  return false;
		}
		
		/**
		 * Determine if the browser is the Yahoo! Slurp Robot or not (last updated 1.7)
		 * @return boolean True if the browser is the Yahoo! Slurp Robot otherwise false
		 */
		protected function checkBrowserSlurp() {
		  if( stripos($this->_agent,'slurp') !== false ) {
		    $aresult = explode('/',stristr($this->_agent,'Slurp'));
		    $aversion = explode(' ',$aresult[1]);
		    $this->setVersion($aversion[0]);
		    $this->_browser_name = self::BROWSER_SLURP;
		    $this->setRobot(true);
		    $this->setMobile(false);
		    return true;
		  }
		  return false;
		}
		
	}
?>