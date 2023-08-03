package TestCases;

import Common.Constant;
import PageObjects.LoginPage;
import PageObjects.GenerateData;
import org.openqa.selenium.JavascriptExecutor;
import org.testng.annotations.Test;

public class TC01 extends TestBase {

    @Test(dataProvider = "dataLogin")
    public void TC01(Object[] dataCsv) {
        LoginPage loginPage = new LoginPage();

        JavascriptExecutor js = (JavascriptExecutor) Constant.DRIVER;
        js.executeScript("arguments[0].scrollIntoView()", loginPage.getBtnLogin());

        String email = GenerateData.generateRandomEmail(dataCsv[0].toString());
        String password = dataCsv[1].toString();

        loginPage.login(email, password);

        
    }
}
