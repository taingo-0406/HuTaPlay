package PageObjects;

import Common.Constant;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;

import javax.swing.*;
import java.sql.Driver;

import static Common.Constant.DRIVER;

public class LeaderboardPage extends BasePage {
    private final By _btnNavigateLanding = By.xpath("//button[@class='trophy_btn' and @onclick='redirectLandingPage()']/img[@alt='Image']");
    public WebElement getBtnNavigateLanding() { return DRIVER.findElement(_btnNavigateLanding); }

    public void navigateLanding() {
        this.getBtnNavigateLanding().click();
    }
}
