package TestCases;

import Common.Constant;
import Common.Log;
import Common.WebDriverUtils;
import com.opencsv.CSVReader;
import org.testng.annotations.*;

import java.io.FileReader;
import java.io.IOException;
import java.io.Reader;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

public class TestBase {

    @BeforeSuite
    @Parameters("browser")
    public void beforeSuite(@Optional("chrome") String browserName){
        Constant.BROWSER = browserName;
    }

    @BeforeMethod
    public void setUp() {
        WebDriverUtils.init();
        WebDriverUtils.navigate(Constant.LOGIN_PAGE_URL);

        Log.info("Navigate to HuTaPlay Website");
    }

    @AfterMethod
    public void tearDown() {
        WebDriverUtils.quitBrowser();

        Log.info("Exit HuTaPlay Website");

    }

    @DataProvider
    public Iterator<Object[]> dataLogin() throws IOException {

        String path = "src/test/java/DataObjects/" + this.getClass().getSimpleName() + ".csv";

        Reader reader = new FileReader(path);
        CSVReader csvreader = new CSVReader(reader);

        List<Object[]> list = new ArrayList<>();
        String[] nextLine= csvreader.readNext();
        while (nextLine != null) {
            Object[] objLine = nextLine;
            list.add(objLine);
            nextLine= csvreader.readNext();
        }

        Iterator<Object[]> dataCsv = list.iterator();
        return dataCsv;
    }
}

