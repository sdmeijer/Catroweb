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

import java.util.HashMap;
import java.util.Random;

import org.testng.annotations.DataProvider;
import org.testng.annotations.Test;
import static org.testng.AssertJUnit.*;

import at.tugraz.ist.catroweb.BaseTest;
import at.tugraz.ist.catroweb.common.*;

public class ReportAsInappropriateTests extends BaseTest {
  @Test(dataProvider = "loginDataAndReportOwnProject", groups = { "catroid" }, description = "login and report own project as inappropriate")
  public void reportOwnProjectAsInappropriate(HashMap<String, String> dataset) throws Throwable {
    // upload project
    Random rand = new Random();
    String projectTitle = "Testproject for report as inappropriate " + rand.nextInt(9999);
    String response = projectUploader.upload(CommonData.getUploadPayload(projectTitle, dataset.get("projectDescription"), dataset.get("projectSource"), dataset
        .get("projectChecksum"), "", "", "", dataset.get("token")));
    assertEquals("200", CommonFunctions.getValueFromJSONobject(response, "statusCode"));
    String projectId = CommonFunctions.getValueFromJSONobject(response, "projectId");

    // login first
    session().open(Config.TESTS_BASE_PATH);
    session().click("headerProfileButton");
    session().type("loginUsername", dataset.get("username"));
    session().type("loginPassword", dataset.get("password"));
    session().click("loginSubmitButton");
    waitForPageToLoad();
    ajaxWait();
    Thread.sleep(Config.TIMEOUT_THREAD);
    assertTrue(session().isVisible("headerProfileButton"));
    session().click("headerProfileButton");
    assertTrue(session().isVisible("logoutSubmitButton"));
    session().click("headerCancelButton");
    assertTrue(session().isTextPresent(projectTitle));

    // goto details page
    session().open(Config.TESTS_BASE_PATH + "catroid/details/" + projectId);
    waitForPageToLoad();
    ajaxWait();
    assertTrue(session().isTextPresent(projectTitle));
    assertTrue(session().isTextPresent(dataset.get("projectDescription")));

    // report as inappropriate not visible
    assertFalse(session().isElementPresent("xpath=//button[@id='reportAsInappropriateButton']"));

    assertTrue(session().isElementPresent("xpath=//button[@id='headerMenuButton']"));
    session().click("xpath=//button[@id='headerMenuButton']");
    waitForPageToLoad();
    ajaxWait();

    session().click("xpath=//button[@id='menuLogoutButton']");
    waitForPageToLoad();
    ajaxWait();

    session().open(Config.TESTS_BASE_PATH + "catroid/details/" + projectId);
    assertTrue(session().isTextPresent(projectTitle));
    assertTrue(session().isTextPresent(dataset.get("projectDescription")));
    // report as inappropriate visible again after logout
    assertTrue(session().isElementPresent("xpath=//button[@id='reportAsInappropriateButton']"));

    session().open(Config.TESTS_BASE_PATH + "catroid/logout");
    waitForPageToLoad();
    ajaxWait();
  }

  @Test(dataProvider = "loginDataAndReportOwnProjectAnonymous", groups = { "catroid" }, description = "report own project as inappropriate anonymously")
  public void testReportAnonymousProjectAsInappropriate(HashMap<String, String> dataset) throws Throwable {
    // upload project
    Random rand = new Random();
    String projectTitle = "Testproject for report as inappropriate (anonymous user) " + rand.nextInt(9999);
    String response = projectUploader.upload(CommonData.getUploadPayload(projectTitle, dataset.get("projectDescription"), dataset.get("projectSource"), dataset
        .get("projectChecksum"), "", "", "", dataset.get("token")));
    assertEquals("200", CommonFunctions.getValueFromJSONobject(response, "statusCode"));
    String projectId = CommonFunctions.getValueFromJSONobject(response, "projectId");

    session().open(Config.TESTS_BASE_PATH);
    waitForPageToLoad();
    ajaxWait();
    Thread.sleep(Config.TIMEOUT_THREAD);
    assertTrue(session().isTextPresent(projectTitle));

    // goto details page
    session().open(Config.TESTS_BASE_PATH + "catroid/details/" + projectId);
    waitForPageToLoad();
    ajaxWait();
    assertTrue(session().isTextPresent(projectTitle));
    assertTrue(session().isTextPresent(dataset.get("projectDescription")));

    // report as inappropriate
    assertTrue(session().isElementPresent("reportAsInappropriateButton"));
    session().click("reportAsInappropriateButton");

    assertTrue(session().isVisible("reportInappropriateReason"));
    assertTrue(session().isVisible("reportInappropriateReportButton"));
    assertTrue(session().isVisible("reportInappropriateCancelButton"));

    session().click("reportAsInappropriateButton");
    session().type("reportInappropriateReason", "my selenium reason");
    session().click("reportInappropriateReportButton");
    ajaxWait();

    assertFalse(session().isVisible("reportInappropriateReason"));
    assertTrue(session().isTextPresent("You reported this project as inappropriate!"));

    // project is hidden
    session().open(Config.TESTS_BASE_PATH);
    waitForPageToLoad();
    ajaxWait();
    assertFalse(session().isTextPresent(projectTitle));
  }

  @DataProvider(name = "loginDataAndReportOwnProject")
  public Object[][] loginDataAndReportOwnProject() {
    Object[][] dataArray = new Object[][] { { new HashMap<String, String>() {
      {
        put("projectDescription", "some description for my test project connected to my user id after registration and login at catroid.org.");
        put("projectSource", "test2.zip");
        put("projectChecksum", "149c6b242dc410650a061292cd40f7d5");
        put("username", "catroweb");
        put("password", "cat.roid.web");
        put("token", createToken("catroweb", "cat.roid.web"));
      }
    } } };
    return dataArray;
  }

  private String createToken(String username, String password) {
    return CommonFunctions.md5(CommonFunctions.md5(username) + ":" + CommonFunctions.md5(password));
  }

  @DataProvider(name = "loginDataAndReportOwnProjectAnonymous")
  public Object[][] loginDataAndReportOwnProjectAnonymous() {
    Object[][] dataArray = new Object[][] { { new HashMap<String, String>() {
      {
        put("projectDescription", "some description for my test project connected to anonymous user id (0) after registration and login at catroid.org.");
        put("projectSource", "test2.zip");
        put("projectChecksum", "149c6b242dc410650a061292cd40f7d5");
        put("token", "0");
      }
    } } };
    return dataArray;
  }
}