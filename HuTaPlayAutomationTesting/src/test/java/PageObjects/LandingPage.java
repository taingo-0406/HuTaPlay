package PageObjects;

import Common.Constant;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.interactions.Actions;

import javax.swing.*;
import java.sql.Driver;

import static Common.Constant.DRIVER;

public class LandingPage extends BasePage {

    private final By _txtWelcome = By.xpath("//h4[@class='text-center']");
    private final By _btnLogout = By.xpath("//input[@type='submit' and @name='logout' and @value='Logout']");
    private final By _btnPointExchange = By.xpath("//button[@type='button' and @data-toggle='modal' and @data-target='#exampleModal']/img[@alt='Image']");
    private final By _btnRedeemCoupon = By.xpath("//tr/td[count(//th[text()='Gift']/preceding-sibling::th) + 1][text()='Coupon 1']/..//button");

    public WebElement getTxtWelcome() {
        return DRIVER.findElement(_txtWelcome);
    }
    public WebElement getBtnLogout() {
        return DRIVER.findElement(_btnLogout);
    }
    public WebElement getBtnPointExchange() { return DRIVER.findElement(_btnPointExchange); }
    public WebElement getBtnRedeemCoupon() { return DRIVER.findElement(_btnRedeemCoupon); }

    Actions actions = new Actions(DRIVER);
    public void logout() {
        actions.moveToElement(getTxtWelcome()).build().perform();
        this.getBtnLogout().click();
    }

    public void pointExchange() {
        this.getBtnPointExchange().click();
        try {
            Thread.sleep(5000); // 5000 milliseconds = 5 seconds
        } catch (InterruptedException e) {
            // handle the exception here
        }
        this.getBtnRedeemCoupon().click();
    }
}
