package TestCases;

import Common.Constant;
import Common.Log;
import PageObjects.*;
import org.openqa.selenium.JavascriptExecutor;
import org.testng.annotations.Test;

public class TC06 extends TestBase {

    @Test(dataProvider = "dataLogin")
    public void TC01(Object[] dataCsv) {

        LoginPage loginPage = new LoginPage();
        LandingPage landingPage = new LandingPage();

        JavascriptExecutor js = (JavascriptExecutor) Constant.DRIVER;
        js.executeScript("arguments[0].scrollIntoView()", loginPage.getBtnLogin());

        String email = GenerateData.generateRandomEmail(dataCsv[0].toString());
        String password = dataCsv[1].toString();

        loginPage.login(email, password);

        Log.info("Move to landing page");

        landingPage.navigateLeaderboard();
        Log.info("Da di den trang Leaderboard");
    }

    @Test(dataProvider = "dataLogin")
    public void TC02(Object[] dataCsv) {

        LoginPage loginPage = new LoginPage();
        LandingPage landingPage = new LandingPage();
        LeaderboardPage leaderboardPage = new LeaderboardPage();

        JavascriptExecutor js = (JavascriptExecutor) Constant.DRIVER;
        js.executeScript("arguments[0].scrollIntoView()", loginPage.getBtnLogin());

        String email = GenerateData.generateRandomEmail(dataCsv[0].toString());
        String password = dataCsv[1].toString();

        loginPage.login(email, password);

        Log.info("Move to landing page");

        landingPage.navigateLeaderboard();
        Log.info("Da di den trang Leaderboard");

        JavascriptExecutor js1 = (JavascriptExecutor) Constant.DRIVER;
        js1.executeScript("arguments[0].scrollIntoView()", leaderboardPage.getBtnNavigateLanding());

        leaderboardPage.navigateLanding();
    }
}
