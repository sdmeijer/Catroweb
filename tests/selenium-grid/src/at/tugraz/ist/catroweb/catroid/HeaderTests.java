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

package at.tugraz.ist.catroweb.catroid;

import static com.thoughtworks.selenium.grid.tools.ThreadSafeSeleniumSessionStorage.session;

import org.testng.annotations.Test;
import static org.testng.AssertJUnit.*;

import at.tugraz.ist.catroweb.BaseTest;
import at.tugraz.ist.catroweb.common.*;

public class HeaderTests extends BaseTest {
  @Test(groups = { "catroid", "firefox", "default" }, description = "check menu home button")
  public void headerMenuButtons() throws Throwable {
    session().open(Config.TESTS_BASE_PATH);
    waitForPageToLoad();
    assertFalse(session().isElementPresent("headerHomeButton"));
    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerProfileButton"));

    session().click("headerMenuButton");
    waitForPageToLoad();
    assertTrue(session().isVisible("headerHomeButton"));
    assertFalse(session().isElementPresent("headerMenuButton"));
    assertTrue(session().isVisible("headerProfileButton"));

    session().click("headerHomeButton");
    waitForPageToLoad();
    ajaxWait();
    assertRegExp(".*/catroid/index(/[0-9]+)?", session().getLocation());
    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerProfileButton"));
    assertFalse(session().isElementPresent("headerHomeButton"));
  }

  @Test(groups = { "catroid", "firefox", "default" }, description = "check header buttons, search bar visibility, etc.")
  public void headerButtonsIndex() {
    session().open(Config.TESTS_BASE_PATH);
    waitForPageToLoad();
   
    assertFalse(session().isVisible("headerSearchBox"));
    assertFalse(session().isVisible("headerCancelButton"));
    assertTrue(session().isVisible("headerSearchButton"));
    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerProfileButton"));

    session().click("headerSearchButton");
    ajaxWait();
    assertTrue(session().isVisible("headerSearchBox"));
    assertTrue(session().isVisible("headerCancelButton"));
    assertFalse(session().isVisible("headerSearchButton"));
    assertFalse(session().isVisible("headerMenuButton"));
    assertFalse(session().isVisible("headerProfileButton"));

    session().click("headerCancelButton");
    ajaxWait();
    assertFalse(session().isVisible("headerSearchBox"));
    assertFalse(session().isVisible("headerCancelButton"));
    assertTrue(session().isVisible("headerSearchButton"));
    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerProfileButton"));

    session().click("headerMenuButton");
    waitForPageToLoad();
    assertRegExp(".*/catroid/menu$", session().getLocation());
  }

  @Test(groups = { "catroid", "firefox", "default" }, description = "home button: check button visibility")
  public void headerHomeButton() throws Throwable {
    session().open(Config.TESTS_BASE_PATH);
    waitForPageToLoad();

    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerSearchButton"));
    assertFalse(session().isElementPresent("headerHomeButton"));

    session().click("xpath=//a[@class='license'][4]");
    waitForPageToLoad();

    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerHomeButton"));
    assertFalse(session().isElementPresent("headerSearchButton"));

    session().click("aIndexWebLogoLeft");
    waitForPageToLoad();
    ajaxWait();

    assertTrue(session().isVisible("headerMenuButton"));
    assertTrue(session().isVisible("headerSearchButton"));
    assertFalse(session().isElementPresent("headerHomeButton"));
  }
}
