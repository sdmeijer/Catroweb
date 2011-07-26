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

require_once('../config.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Catroid cheat sheet</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>
<body>
	<div id="all">
		<div id="antcommands">
			<h1>ant cheatsheet</h1>
			<pre>
--- local tests

    ant run-phpunit-tests		 
    ant run-selenium-admin-tests    
    ant run-selenium-local-tests
    ant run-selenium-api-tests      
    ant run-selenium-catroid-tests
    
    <i>+ run specific test</i>
    ant run-selenium-single-test    
    ant run-selenium-single-test -Dtest.browserName=firefox -Dtest.class=catroid.LicenseTests -Dtest.method=imprint
    
    <i>+ run specific group of tests</i>
    ant run-selenium-group-test
    ant run-selenium-group-test -Dtest.browserName=firefox -Dtest.group=admin    
    
    <i>+ Shut down local Selenium processes</i> 
    ant stop-selenium-grid

--- android tests
    --> see WIKI for installation instructions!     
    <i>+ starts android emulator with webdriver configuration</i>
    ant start-android-emulator
    <i>+ run tests with -DwebSite=http://10.0.2.2/</i> i.e.:    
    ant run-selenium-single-test -Dtest.browserName=android -Dtest.class=catroid.LicenseTests -Dtest.method=imprint -DwebSite=http://10.0.2.2/

--- remote tests

    <i>+ Connect remote controls to kittyroid test server</i> 
    ant selenium-tools.launch-remote-control -DhubURL http://kittyroidlocal:4444/grid/register

    <i>+ Start remote test on kityroid test server</i>
    ant run-selenium-remote-tests -Dhost.user=catroid -Dhost.pass=cat.roid.web -Dtest.browserName=firefox

--- database 

    ant init-db
    ant update-db
      </pre>
		</div>
		<div id="links">
			<h1>Localhost</h1>
			<a href="http://<?php echo $_SERVER['SERVER_NAME']?>:4444/grid/console" target="_blank">Grid	Console</a><br> 
			<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tests/selenium-grid/target/reports/" target="_blank">Test	Reports</a><br> 
			<a href="http://<?php echo $_SERVER['SERVER_NAME']?>/phppgadmin/" target="_blank">phppgadmin</a><br>
			
			<h1>kittyroidlocal</h1> 
			<a href="http://kittyroidlocal:4444/grid/console" target="_blank">Grid Console</a><br>
			<a href="http://kittyroidlocal/tests/selenium-grid/target/reports/" target="_blank">Test Reports</a>
      <h1>Catroidwebtest</h1> 
      <a href="http://catroidwebtest.ist.tugraz.at/" target="_blank">Catroidwebtest</a><br>
      <a href="http://catroidwebtest.ist.tugraz.at:8080" target="_blank">Pootle Server</a><br>
      <a href="http://catroidwebtest.ist.tugraz.at/sql-overview/" target="_blank">SQL	Overview</a><br>
      
      <h1>Other</h1> <a href="http://catroid.org" target="_blank">Catroid.org</a><br>
			<a href="http://kittyroid.org" target="_blank">Kittyroid.org</a><br> 
			<a href="http://catroidtest.ist.tugraz.at/" target="_blank">Catroidtest</a><br>		
		</div>
	</div>
</body>
</html>
<?
?>