package TestCases;

import Common.Constant;
import Common.Log;
import PageObjects.LandingPage;
import PageObjects.LoginPage;
import PageObjects.GenerateData;
import PageObjects.RegisterPage;
import org.openqa.selenium.JavascriptExecutor;
import org.testng.annotations.Test;

public class TC05 extends TestBase {

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

        landingPage.checkHistoryRedeem();
        Log.info("Da check duoc lich su redeem");
    }
}
