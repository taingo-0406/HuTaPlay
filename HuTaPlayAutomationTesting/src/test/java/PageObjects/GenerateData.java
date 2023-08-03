package PageObjects;

import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

public class GenerateData {
    public static String generateString() {
        DateTimeFormatter dateTimeFormatter = DateTimeFormatter.ofPattern("yyMMddHHmmss");
        LocalDateTime now = LocalDateTime.now();
        return dateTimeFormatter.format(now);
    }

    public static String generateRandomEmail(String email) {
        String[] parts = email.split("@");
        String part1 = parts[0];
        String part2 = parts[1];
        return part1 + "+" + generateString() + "@" + part2;
    }
}
