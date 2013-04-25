<?php
/*
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

?>
    <script type="text/javascript">
      $(document).ready(function() {
        //new Projects(<?php echo "'".PROJECT_PAGE_LOAD_MAX_PROJECTS."', '".PROJECT_PAGE_SHOW_MAX_PAGES."', '".$this->module->session->pageNr."', '".$this->module->session->searchQuery."', '".$this->module->session->task."', { loading: '".$this->languageHandler->getString("template_header_loading")."' }"; ?>);
        new Projects(<?php echo $this->jsParams; ?>);
      });
    </script>
    <div class="webMainTop">
      <div class="blueBoxMain">
        <div class="webMainHead">
          <div class="webHeadLogo<?php if(isItChristmas()) echo " webHeadLogoXmas";?>">
            <a id="aIndexWebLogoLeft" href="<?php echo BASE_PATH?>catroid/index/0">
            <img class="catroidLogo" src="<?php echo BASE_PATH?>images/logo/logo_head<?php if(isItChristmas()) echo "_xmas";?>.png" alt="head logo" />
            </a>
          </div>
          <div class="webHeadTitle">
            <div class="webHeadTitleName">
              <a id="aIndexWebLogoMiddle" href="<?php echo BASE_PATH?>catroid/index/0">
              <img class="catroidLettering" src="<?php echo BASE_PATH?>images/logo/logo_lettering.png" alt="catroid [beta]" />
              </a>
            </div>
          </div>
          <div id="normalHeaderButtons" class="webHeadButtons">
            <button type="button" class="webHeadButtons button orange medium" id="headerMenuButton"><img class="webHeadSymbolOnButton" src="<?php echo BASE_PATH?>images/symbols/wall.png" alt="<?php echo $this->languageHandler->getString('template_header_menu')?>" /></button>
            <button type="button" class="webHeadButtons button orange medium" id="headerProfileButton"><img class="webHeadSymbolOnButton" src="<?php echo BASE_PATH?>images/symbols/menu_profile.png" alt="<?php echo $this->languageHandler->getString('template_header_profile')?>" /></button>
          </div>
          <div id="cancelHeaderButton" class="webHeadButtons">
            <button type="button" class="webHeadCancelButton button orange medium" id="headerCancelButton">
              <span class="webHeadCancelButtonText"><?php echo $this->languageHandler->getString('template_header_cancel')?></span>
            </button>
          </div>          
          <div style="clear:both;"></div>
        </div>
      </div>
<?php require_once('loginbox.php'); ?>

    </div> <!--  WEBMAINTOP -->