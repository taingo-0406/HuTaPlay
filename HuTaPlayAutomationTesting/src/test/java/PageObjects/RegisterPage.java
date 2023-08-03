package PageObjects;

import Common.Constant;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;

public class RegisterPage extends BasePage{

    private final By _txtUsername = By.xpath("//input[@class='input100' and @type='text' and @name='fullname']");
    private final By _txtEmail = By.xpath("//input[@class='input100' and @type='text' and @name='email']");
    private final By _txtPassword = By.xpath("//input[@class='input100' and @type='password' and @name='password']");
    private final By _btnLogin = By.xpath("//button[@class='login100-form-btn']");

    private final By _btnOK = By.xpath("//div[@class='text-center p-t-115']/a[@href='login.php']");

    public WebElement getTxtusername() {
        return Constant.DRIVER.findElement(_txtUsername);
    }

    public WebElement getTxtEmail() { return Constant.DRIVER.findElement(_txtEmail);}

    public WebElement getTxtPassword() {
        return Constant.DRIVER.findElement(_txtPassword);
    }

    public WebElement getBtnRegister() {
        return Constant.DRIVER.findElement(_btnLogin);
    }

    public WebElement getBtnOK() { return Constant.DRIVER.findElement(_btnOK);}

    public void register(String username, String email, String password) {
        this.getTxtusername().sendKeys(username);
        this.getTxtEmail().sendKeys(email);
        this.getTxtPassword().sendKeys(password);
        this.getBtnRegister().click();
        try {
            Thread.sleep(5000); // 5000 milliseconds = 5 seconds
        } catch (InterruptedException e) {
            // handle the exception here
        }
        this.getBtnOK().click();
    }
}
