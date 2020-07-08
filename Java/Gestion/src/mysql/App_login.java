package mysql;

import javax.swing.*;
import javax.swing.JFrame;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.math.BigInteger;
import java.nio.charset.StandardCharsets;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.*;

public class App_login {
    private JPanel MyPanel;
    private JTextField email_input;
    private JTextField firstname_input;
    private JButton loginButton;
    String email;
    String password;
    JFrame frame;

    public App_login() {
        loginButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                email = email_input.getText();
                password = firstname_input.getText();
                connexion(email,password);
            }
        });
    }

    public static byte[] getSHA(String input) throws NoSuchAlgorithmException
    {
        // Static getInstance method is called with hashing SHA
        MessageDigest md = MessageDigest.getInstance("SHA-256");

        // digest() method called
        // to calculate message digest of an input
        // and return array of byte
        return md.digest(input.getBytes(StandardCharsets.UTF_8));
    }

    public static String toHexString(byte[] hash)
    {
        // Convert byte array into signum representation
        BigInteger number = new BigInteger(1, hash);

        // Convert message digest into hex value
        StringBuilder hexString = new StringBuilder(number.toString(16));

        // Pad with leading zeros
        while (hexString.length() < 32)
        {
            hexString.insert(0, '0');
        }

        return hexString.toString();
    }

    public static void main(String[] args){
        App_login test = new App_login();
        test.affichage();
    }

    public void affichage(){
        frame= new JFrame("App");
        frame.setContentPane(new App_login().MyPanel);
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.pack();
        frame.setSize(580,372);
        frame.setVisible(true);
    }

    public void connexion(String email, String password){

        try {

            String stockEncrypt = toHexString(getSHA(password));
            Class.forName("com.mysql.jdbc.Driver");
            Connection con= DriverManager.getConnection("jdbc:mysql://51.77.158.251:3306/drivncook","remote","jesuisunclown");


            PreparedStatement statement = con.prepareStatement("select * from user where email = ? and password = ?");
            statement.setString(1,email);
            statement.setString(2,stockEncrypt);

            ResultSet rs=statement.executeQuery();
            if (rs.next() ){
                System.out.println(rs.getString("email"));
                card_fidelity.main(null);

            }
            else{
                System.out.println("hello");
                System.out.println(toHexString(getSHA(password)));
            }
            con.close();
        }catch(Exception e){
            System.out.println("SQLException: " + e.getMessage());
        }
    }
}
