package PageObjects;

import Common.Constant;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;

public class LoginPage extends BasePage {
    private final By _txtUsername = By.xpath("//input[@class='input100' and @type='text' and @name='email']");
    private final By _txtPassword = By.xpath("//input[@class='input100' and @type='password' and @name='password']");
    private final By _btnLogin = By.xpath("//button[@class='login100-form-btn']");

    public WebElement getTxtusername() {
        return Constant.DRIVER.findElement(_txtUsername);
    }

    public WebElement getTxtPassword() {
        return Constant.DRIVER.findElement(_txtPassword);
    }

    public WebElement getBtnLogin() {
        return Constant.DRIVER.findElement(_btnLogin);
    }

    public void login(String username, String password) {
        this.getTxtusername().sendKeys(username);
        this.getTxtPassword().sendKeys(password);
        this.getBtnLogin().click();
    }
}
