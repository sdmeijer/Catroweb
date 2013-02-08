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

$this->module->addGlobalCss('baseStyle.css');
$this->module->addGlobalCss('header.css');
$this->module->addGlobalCss('buttons.css');
$this->module->addGlobalCss('login.css');

$this->module->addGlobalJs('baseClassVars.js');
$this->module->addGlobalJs('classy.js');
$this->module->addGlobalJs('commonFunctions.js');
$this->module->addGlobalJs('headerMenu.js');
$this->module->addGlobalJs('login.js');
$this->module->addGlobalJs('languageHandler.js');

?>
<!DOCTYPE HTML>
<html lang="<?php echo $this->languageHandler->getLanguage()?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <!-- <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, minimum-scale=1.0, maximum-scale=1.3, initial-scale=1.0, user-scalable=yes" /> -->
    
  <title><?php echo $this->getWebsiteTitle() ?></title>
  <?php echo $this->getGlobalCss(); ?>
  <?php echo $this->getCss(); ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo JQUERY_VERSION; ?>/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo BASE_PATH . CACHE_PATH; ?>jquery<?php echo JQUERY_VERSION; ?>.min.js"><\/script>')</script>
  <?php echo $this->getGlobalJs(); ?>
  <?php echo $this->getJs(); ?>
  <link rel="icon" href="<?php echo BASE_PATH?>images/logo/favicon.png<?php echo '?'.VERSION?>" type="image/png" />
  
<?php if(!$this->isMobile)  {?>
  <link href="<?php echo BASE_PATH . CSS_PATH; ?>baseStyleDesktop.css?<?php echo VERSION; ?>" media="screen" rel="stylesheet" type="text/css" />
<?php }?>
</head>

<body>
  <script type="text/javascript">
    var languageStringsObject = { 
      "ajax_took_too_long" : "<?php echo $this->module->errorHandler->getError('viewer', 'ajax_took_too_long'); ?>",
      "ajax_timed_out" : "<?php echo $this->module->errorHandler->getError('viewer', 'ajax_timed_out'); ?>"
    };
    var common = new Common(languageStringsObject);
  </script>
  <div class="webMainContainer">
<?php include($this->header);?>

  <div id="ajaxAnswerBoxContainer">
    <div id="ajaxAnswerBox" class="blueBoxMain">
      <div class="whiteBoxMain"></div>
    </div>
  </div>

<?php include($this->viewer);?>
  
<?php include($this->footer);?>
  </div>
<?php echo '  <img src="' . googleAnalyticsGetImageUrl() . '" />'; ?> 
</body>
</html>
