package TestCases;

import Common.Constant;
import Common.Log;
import PageObjects.LoginPage;
import PageObjects.GenerateData;
import PageObjects.RegisterPage;
import org.openqa.selenium.JavascriptExecutor;
import org.testng.annotations.Test;

public class TC02 extends TestBase {

    LoginPage loginPage = new LoginPage();
    RegisterPage registerPage = new RegisterPage();

    @Test(dataProvider = "dataLogin")
    public void TC01(Object[] dataCsv) throws InterruptedException {

        JavascriptExecutor js = (JavascriptExecutor) Constant.DRIVER;
        js.executeScript("arguments[0].scrollIntoView()", loginPage.getLnkRegisterTab());

        loginPage.moveToRegisterPage();

        String username = dataCsv[0].toString();
        String email = GenerateData.generateRandomEmail(dataCsv[1].toString());
        String password = dataCsv[2].toString();

        registerPage.register(username ,email, password);

        JavascriptExecutor js1 = (JavascriptExecutor) Constant.DRIVER;
        js1.executeScript("arguments[0].scrollIntoView()", loginPage.getBtnLogin());

        loginPage.login(email, password);

        Log.info("Move to Landing page");
    }
}
