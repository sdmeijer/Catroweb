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

 <SCRIPT>
 <!--
 /*
 Script by FPMC at http://jsarchive.8m.com
 Submitted to JavaScript Kit (http://javascriptkit.com)
 For this and 400+ free scripts, visit http://javascriptkit.com
 */
 src = ["resources/featured/1.gif", "resources/featured/2.jpg"];
 duration = 2;
 ads=[]; ct=0;
 function switchAd() {
   var n=(ct+1)%src.length;
   if (ads[n] && (ads[n].complete || ads[n].complete==null)) {
     document["Ad_Image"].src = ads[ct=n].src;
     }
   ads[n=(ct+1)%src.length] = new Image;
   ads[n].src = src[n];
   setTimeout("switchAd()",duration*1000);
   }
 function doLink(){
   location.href = url[ct];
   } onload = function(){
     if (document.images)
       switchAd();
     };
 //-->
 </SCRIPT>


      <article>
        <div id="programmOfTheWeek">
          <header><?php echo $this->languageHandler->getString('recommended'); ?></header>
          <div id="slideshow"><img name="Ad_Image" src="<?php echo BASE_PATH; ?>resources/featured/1.png" border=0 alt="">
          </div>
        </div>
        <div class="projectSpacer"></div>

        <header><?php echo $this->languageHandler->getString('newestProjects'); ?></header>
        <div id="newestProjects" class="projectContainer"></div>
        <div id="newestProjectsLoader" class="projectFooter">
          <img src="<?php echo BASE_PATH; ?>images/symbols/ajax-loader-dark.gif" />
          <p>&nbsp;</p>
        </div>
        <div id="newestShowMore" class="projectFooter">
          <div class="img-load-more"></div>
          <!-- <p><?php echo $this->languageHandler->getString('showMore'); ?></p>-->
        </div>
        <div class="projectSpacer"></div>

        <header><?php echo $this->languageHandler->getString('mostDownloaded'); ?></header>
        <div id="mostDownloadedProjects" class="projectContainer"></div>
        <div id="mostDownloadedProjectsLoader" class="projectFooter">
          <img src="<?php echo BASE_PATH; ?>images/symbols/ajax-loader-dark.gif" />
          <p>&nbsp;</p>
        </div>
        <div id="mostDownloadedShowMore" class="projectFooter">
          <div class="img-load-more"></div>
          <!-- <p><?php echo $this->languageHandler->getString('showMore'); ?></p>-->
        </div>
        <div class="projectSpacer"></div>

        <header><?php echo $this->languageHandler->getString('mostViewed'); ?></header>
        <div id="mostViewedProjects" class="projectContainer"></div>
        <div id="mostViewedProjectsLoader" class="projectFooter">
          <img src="<?php echo BASE_PATH; ?>images/symbols/ajax-loader-dark.gif" />
          <p>&nbsp;</p>
        </div>
        <div id="mostViewedShowMore" class="projectFooter">
          <div class="img-load-more"></div>
          <!-- <p><?php echo $this->languageHandler->getString('showMore'); ?></p>-->
        </div>
        <div class="projectSpacer"></div>

      </article>
      <script type="text/javascript">
        $(document).ready(function() {
          var pageLabels = { 'websiteTitle' : '<?php echo SITE_DEFAULT_TITLE; ?>'};
          var index = Index(pageLabels, <?php echo $this->featuredProject; ?>);

          var newest = ProjectObject(<?php echo $this->newestProjectsParams; ?>, {'history' : $.proxy(index.saveHistoryState, index) });
          var downloads = ProjectObject(<?php echo $this->mostDownloadedProjectsParams; ?>, {'history' : $.proxy(index.saveHistoryState, index) });
          var views = ProjectObject(<?php echo $this->mostViewedProjectsParams; ?>, {'history' : $.proxy(index.saveHistoryState, index) });
          index.setProjectObjects(newest, downloads, views);

          newest.init();
          downloads.init();
          views.init();
        });
      </script>
