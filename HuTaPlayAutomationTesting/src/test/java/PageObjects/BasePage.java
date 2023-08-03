package PageObjects;

import Common.Constant;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
public class BasePage {

    private By lnkRegister = By.xpath("//a[@class='txt2']");

    public WebElement getLnkRegisterTab() { return Constant.DRIVER.findElement(lnkRegister);}

    public void moveToRegisterPage() { getLnkRegisterTab().click();}
}
