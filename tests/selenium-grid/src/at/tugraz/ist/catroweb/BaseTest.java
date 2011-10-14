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

package at.tugraz.ist.catroweb;

import java.io.File;
import java.io.IOException;
import java.lang.reflect.Method;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Set;

import static org.testng.AssertJUnit.assertTrue;

import org.apache.commons.io.FileUtils;
import org.openqa.selenium.By;
import org.openqa.selenium.ElementNotVisibleException;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.NoSuchElementException;
import org.openqa.selenium.OutputType;
import org.openqa.selenium.TakesScreenshot;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebDriverException;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.android.AndroidDriver;
import org.openqa.selenium.firefox.FirefoxProfile;
import org.openqa.selenium.ie.InternetExplorerDriver;
import org.openqa.selenium.remote.Augmenter;
import org.openqa.selenium.remote.DesiredCapabilities;
import org.openqa.selenium.remote.RemoteWebDriver;
import org.openqa.selenium.support.ui.ExpectedCondition;
import org.openqa.selenium.support.ui.Wait;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.testng.Reporter;
import org.testng.annotations.BeforeClass;
import org.testng.annotations.AfterClass;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.Parameters;

import at.tugraz.ist.catroweb.common.CommonFunctions;
import at.tugraz.ist.catroweb.common.CommonStrings;
import at.tugraz.ist.catroweb.common.Config;
import at.tugraz.ist.catroweb.common.ProjectUploader;

public class BaseTest {
  protected ProjectUploader projectUploader;
  protected String webSite;
  protected Map<String, WebDriver> driverSessions;

  @BeforeClass(alwaysRun = true)
  @Parameters({ "webSite", "basedir" })
  protected void constructor(String webSite, String basedir) {
    this.webSite = webSite;
    Config.setSeleniumGridTestdata(basedir);
    projectUploader = new ProjectUploader(webSite);
    this.driverSessions = Collections.synchronizedMap(new HashMap<String, WebDriver>());
  }

  @AfterClass(alwaysRun = true)
  protected void destructor() {
    projectUploader.cleanup();
  }

  @BeforeMethod(alwaysRun = true)
  @Parameters({ "seleniumHost", "seleniumPort", "browser", "webSite" })
  protected void startSession(String seleniumHost, int seleniumPort, String browser, String webSite, Method method) {
    if(browser.matches("^firefox$")) {
      startFirefoxSession(seleniumHost, seleniumPort, method.getName());
    } else if(browser.matches("^chrome$")) {
      startChromeSession(seleniumHost, seleniumPort, method.getName());
    } else if(browser.matches("^internet explorer$")) {
      startInternetExplorerSession(seleniumHost, seleniumPort, method.getName());
    } else if(browser.matches("^opera$")) {
      startOperaSession(seleniumHost, seleniumPort, method.getName());
    } else if(browser.matches("^android$")) {
      startAndroidSession(seleniumHost, seleniumPort, browser, webSite, method.getName());
    }
  }

  protected void startFirefoxSession(String seleniumHost, int seleniumPort, String method) {
    log("firefox: running " + method + "...");
    FirefoxProfile profile = new FirefoxProfile();

    try {
      DesiredCapabilities capabilities = DesiredCapabilities.firefox();
      capabilities.setCapability("firefox_profile", profile);
      WebDriver driver = new RemoteWebDriver(new URL("http://" + seleniumHost + ":" + seleniumPort + "/wd/hub"), capabilities);
      driverSessions.put(method, driver);
    } catch(MalformedURLException e) {
      e.printStackTrace();
    } catch(Exception e) {
      log(e.getMessage());
    }
  }

  protected void startInternetExplorerSession(String seleniumHost, int seleniumPort, String method) {
    log("internet explorer: running " + method + "...");

    try {
      DesiredCapabilities capabilities = DesiredCapabilities.internetExplorer();
      capabilities.setCapability(InternetExplorerDriver.INTRODUCE_FLAKINESS_BY_IGNORING_SECURITY_DOMAINS, true);
      WebDriver driver = new RemoteWebDriver(new URL("http://" + seleniumHost + ":" + seleniumPort + "/wd/hub"), capabilities);
      driverSessions.put(method, driver);
    } catch(MalformedURLException e) {
      e.printStackTrace();
    } catch(Exception e) {
      log(e.getMessage());
    }
  }

  protected void startChromeSession(String seleniumHost, int seleniumPort, String method) {
    log("chrome: running " + method + "...");
    // System.setProperty("webdriver.chrome.bin", "/opt/google/chrome/google-chrome");
    // System.setProperty("webdriver.chrome.driver", "/home/chris/.workspace/catroweb/tests/selenium-grid/chromedriver");

    try {
      DesiredCapabilities capabilities = DesiredCapabilities.chrome();
      WebDriver driver = new RemoteWebDriver(new URL("http://" + seleniumHost + ":" + seleniumPort + "/wd/hub"), capabilities);
      driverSessions.put(method, driver);
    } catch(MalformedURLException e) {
      e.printStackTrace();
    } catch(Exception e) {
      log(e.getMessage());
    }
  }

  protected void startOperaSession(String seleniumHost, int seleniumPort, String method) {
    log("opera: running " + method + "...");

    try {
      DesiredCapabilities capabilities = DesiredCapabilities.opera();
      WebDriver driver = new RemoteWebDriver(new URL("http://" + seleniumHost + ":" + seleniumPort + "/wd/hub"), capabilities);
      driverSessions.put(method, driver);
    } catch(MalformedURLException e) {
      e.printStackTrace();
    } catch(Exception e) {
      log(e.getMessage());
    }
  }

  protected void startAndroidSession(String seleniumHost, int seleniumPort, String browser, String webSite, String method) {
    log("android: running " + method + "...");
    
    WebDriver driver = new AndroidDriver();
    driverSessions.put(method, driver);
  }

  @AfterMethod(alwaysRun = true)
  protected void closeSession(Method method) {
    String methodName = method.getName();

    getDriverObject(methodName).quit();
    driverSessions.remove(methodName);

    log("..." + methodName + " done");
  }

  protected WebDriver driver() {
    return getDriverObject(getCalleeName());
  }

  private String getCalleeName() {
    StackTraceElement[] stack = Thread.currentThread().getStackTrace();
    for(StackTraceElement item : stack) {
      String entry = item.toString();
      if(entry.matches("at.tugraz.ist.catroweb.*") && !entry.matches("at.tugraz.ist.catroweb.BaseTest.*")) {
        return item.getMethodName();
      }
    }
    return null;
  }

  private WebDriver getDriverObject(String key) {
    if(this.driverSessions.containsKey(key)) {
      return this.driverSessions.get(key);
    }
    return null;
  }

  protected void ajaxWait() {
    Wait<WebDriver> wait = new WebDriverWait(driver(), Config.TIMEOUT_WAIT);
    wait.until(jQueryExists());
    wait.until(jQueryReady());
  }

  public void assertRegExp(String pattern, String string) {
    boolean match = string.matches(pattern); 
    if(!match) {
      log("assertRegExp: was [" + string + "] expected [" + pattern + "]");
    }
    assertTrue(match);
  }
  
  public boolean isTextPresent(String text) {
    return containsElementText(By.tagName("body"), text);
  }
  
  public boolean containsElementText(By selector, String text) {
    // https://code.google.com/p/selenium/issues/detail?id=1438
    waitForElementPresent(selector);
    driver().switchTo().defaultContent(); // TODO workaround
    return (driver().findElement(selector)).getText().contains(text);
  }

  public boolean isElementPresent(By selector) {
    try {
      driver().findElement(selector);
      return true;
    } catch(NoSuchElementException e) {
      return false;
    }
  }

  public boolean isVisible(By selector) {
    return (driver().findElement(selector)).isDisplayed();
  }

  public boolean isEditable(By selector) {
    return (driver().findElement(selector)).isEnabled();
  }

  protected void openLocation() {
    openLocation("");
  }

  protected void openLocation(String location) {
    openLocation(location, true);
  }

  protected void openLocation(String location, Boolean forceDefaultLanguage) {
    if(forceDefaultLanguage == true) {
      driver().get(this.webSite + Config.TESTS_BASE_PATH.substring(1) + location + "?userLanguage=" + Config.SITE_DEFAULT_LANGUAGE);
    } else {
      driver().get(this.webSite + Config.TESTS_BASE_PATH.substring(1) + location);
    }
  }

  protected void openAdminLocation() {
    openAdminLocation("");
  }

  protected void openAdminLocation(String location) {
    driver().get(CommonFunctions.getAdminPath(this.webSite) + location);
  }

  protected void clickAndWaitForPopUp(By selector) {
    String popUpWindow = "";
    Set<String> windowList = driver().getWindowHandles();
    driver().findElement(selector).click();

    Set<String> tmp = driver().getWindowHandles();
    for(String window : tmp) {
      if(!tmp.contains(windowList))
        popUpWindow = window;
    }

    driver().switchTo().window(popUpWindow);
    waitForElementPresent(By.tagName("body"));
  }

  protected void closePopUp() {
    driver().close();
    Set<String> windowList = driver().getWindowHandles();
    for(String window : windowList) {
      driver().switchTo().window(window);
      return;
    }
  }

  protected void clickOkOnNextConfirmationBox() {
    ((JavascriptExecutor) driver()).executeScript("window.confirm = function(msg){return true;};");
  }

  protected void assertProjectPresent(String project) {
    openLocation();
    ajaxWait();
    try {
      driver().findElement(By.id("headerSearchButton")).click();
      ajaxWait();
    } catch(ElementNotVisibleException ignore) {
    }
    assertTrue(isVisible(By.id("searchQuery")));
    driver().findElement(By.id("searchQuery")).clear();
    driver().findElement(By.id("searchQuery")).sendKeys("clear-cache");
    driver().findElement(By.id("webHeadSearchSubmit")).click();
    ajaxWait();
    driver().findElement(By.id("searchQuery")).clear();
    driver().findElement(By.id("searchQuery")).sendKeys(project);
    driver().findElement(By.id("webHeadSearchSubmit")).click();
    ajaxWait();
    assertTrue(isTextPresent(project));
  }

  protected void assertProjectNotPresent(String project) {
    openLocation();
    ajaxWait();
    try {
      driver().findElement(By.id("headerSearchButton")).click();
      ajaxWait();
    } catch(ElementNotVisibleException ignore) {
    }
    assertTrue(isVisible(By.id("searchQuery")));
    driver().findElement(By.id("searchQuery")).clear();
    driver().findElement(By.id("searchQuery")).sendKeys("clear-cache");
    driver().findElement(By.id("webHeadSearchSubmit")).click();
    ajaxWait();
    driver().findElement(By.id("searchQuery")).clear();
    driver().findElement(By.id("searchQuery")).sendKeys(project);
    driver().findElement(By.id("webHeadSearchSubmit")).click();
    ajaxWait();
    assertTrue(isTextPresent(CommonStrings.SEARCH_PROJECTS_PAGE_NO_RESULTS));
  }

  public void waitForElementPresent(By selector) {
    try {
      Wait<WebDriver> wait = new WebDriverWait(driver(), Config.TIMEOUT_WAIT);
      wait.until(elementPresent(selector));
    } catch(WebDriverException ignore) {
    }
  }

  public void clickLastVisibleProject() {
    try {
      while(driver().findElement(By.id("moreProjects")).isDisplayed()) {
        driver().findElement(By.id("moreProjects")).click();
        ajaxWait();
      }
    } catch(NoSuchElementException ignore) {
    }

    WebElement lastLink = null;
    List<WebElement> allLinks = driver().findElements(By.tagName("a"));
    for(WebElement link : allLinks) {
      if(link.getAttribute("class").equals("projectListDetailsLinkBold") && link.isDisplayed()) {
        lastLink = link;
      }
    }
    lastLink.click();
  }

  protected void log(int message) {
    Reporter.log(String.valueOf(message), Config.REPORTER_LOG_TO_STD_OUT);
  }

  protected void log(String message) {
    Reporter.log(message, Config.REPORTER_LOG_TO_STD_OUT);
  }

  protected void captureScreen(String imageName) {
    WebDriver driver = new Augmenter().augment(driver());
    String imageExtension = ".png";
    String imagePath = Config.SELENIUM_GRID_TARGET + imageName + imageExtension;
    try {
      File scrFile = ((TakesScreenshot) driver).getScreenshotAs(OutputType.FILE);
      FileUtils.copyFile(scrFile, new File(Config.FILESYSTEM_BASE_PATH + imagePath));
      Reporter.log("<a href=\"" + this.webSite + Config.TESTS_BASE_PATH.substring(1) + imagePath + "\">Screenshot (" + imageName + ")</a>");
    } catch(IOException e) {
      e.printStackTrace();
    } catch(NullPointerException e) {
      Reporter.log("captureScreen got NULL pointer");
    }
  }

  private ExpectedCondition<WebElement> elementPresent(final By selector) {
    return new ExpectedCondition<WebElement>() {
      public WebElement apply(WebDriver driver) {
        return driver.findElement(selector);
      }
    };
  }

  private ExpectedCondition<Boolean> jQueryExists() {
    return new ExpectedCondition<Boolean>() {
      public Boolean apply(WebDriver driver) {
        return((Boolean) ((JavascriptExecutor) driver).executeScript("return (typeof window.jQuery == 'function')"));
      }
    };
  }

  private ExpectedCondition<Boolean> jQueryReady() {
    return new ExpectedCondition<Boolean>() {
      public Boolean apply(WebDriver driver) {
        return((Boolean) ((JavascriptExecutor) driver).executeScript("return (window.jQuery.active == 0)"));
      }
    };
  }
}
