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
    private final By _btnPointExchange = By.xpath("//button[@type='button' and @class='cartbtn' and @data-toggle='modal' and @data-target='#exchangeModal']/img[@alt='Image']");
    private final By _btnHistoryRedeem = By.xpath("//button[@type='button' and @class='historybtn' and @data-toggle='modal' and @data-target='#historyModal']/img[@alt='Image']");
    private final By _btnRedeemCoupon = By.xpath("//tr/td[count(//th[text()='Gift']/preceding-sibling::th) + 1][text()='Coupon 1']/..//button");
    private final By _btnOkRedeemCoupon = By.xpath("//button[@type='button' and @class='swal2-confirm swal2-styled' and @aria-label]");
    private final By _btnCancelRedeemCoupon = By.xpath("//button[@type='button' and @class='swal2-deny swal2-styled' and @aria-label]");
    private final By _btnNavigateLeaderBoard = By.xpath("//button[@class='trophy_btn' and @onclick='redirectLeaderBoard()']/img[@alt='Image']");
    public WebElement getTxtWelcome() {
        return DRIVER.findElement(_txtWelcome);
    }
    public WebElement getBtnLogout() {
        return DRIVER.findElement(_btnLogout);
    }
    public WebElement getBtnPointExchange() { return DRIVER.findElement(_btnPointExchange); }
    public WebElement getBtnHistoryRedeem() { return DRIVER.findElement(_btnHistoryRedeem); }
    public WebElement getBtnRedeemCoupon() { return DRIVER.findElement(_btnRedeemCoupon); }
    public WebElement getBtnOkRedeemCoupon() { return DRIVER.findElement(_btnOkRedeemCoupon); }
    public WebElement getBtnCancelRedeemCoupon() { return DRIVER.findElement(_btnCancelRedeemCoupon); }
    public WebElement getBtnNavigateLeaderboard() { return DRIVER.findElement(_btnNavigateLeaderBoard); }

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
        try {
            Thread.sleep(5000); // 5000 milliseconds = 5 seconds
        } catch (InterruptedException e) {
            // handle the exception here
        }
        this.getBtnOkRedeemCoupon().click();
        try {
            Thread.sleep(5000); // 5000 milliseconds = 5 seconds
        } catch (InterruptedException e) {
            // handle the exception here
        }
        this.getBtnOkRedeemCoupon().click();

    }

    public void checkHistoryRedeem() {
        this.getBtnHistoryRedeem().click();
    }

    public void navigateLeaderboard() {
        this.getBtnNavigateLeaderboard().click();
    }

}
