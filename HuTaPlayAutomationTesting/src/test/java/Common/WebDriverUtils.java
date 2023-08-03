package Common;

import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.edge.EdgeDriver;
import org.openqa.selenium.firefox.FirefoxDriver;

public class WebDriverUtils {
    public static void init() {
                System.setProperty("webdriver.chrome.driver", "Executables/Driver/chromedriver_newest.exe");
                Constant.DRIVER = new ChromeDriver();
                Constant.DRIVER.manage().window().maximize();
    }

    public static void navigate(String URL) {
        Constant.DRIVER.get(URL);
    }

    public static void quitBrowser() {
        Constant.DRIVER.quit();
    }


}
