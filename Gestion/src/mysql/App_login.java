package mysql;

import javax.swing.*;
import javax.swing.JFrame;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
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
    String firstName;
    private JFrame frame;

    public App_login() {
        loginButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                email = email_input.getText();
                firstName = firstname_input.getText();
                connexion(email,firstName);
            }
        });
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

    public void connexion(String email, String firstName){

        try {

            Class.forName("com.mysql.jdbc.Driver");
            Connection con= DriverManager.getConnection("jdbc:mysql://51.77.158.251:3306/drivncook","drivncook","Kamalthebest!");
            //here sonoo is database name, root is username and password

            PreparedStatement statement = con.prepareStatement("select * from franchise where email = ? and first_name = ?");
            statement.setString(1,email);
            statement.setString(2,firstName);

            ResultSet rs=statement.executeQuery();
            if (rs.next() ){
                System.out.println(rs.getString("email"));
                card_fidelity.main(null);

            }
            else{
                System.out.println("hello");
            }

              //  System.out.println(rs.getInt("id")+"  "+rs.getString("email")+"  "+rs.getString(3));
                //and add this row of data into the table model

            con.close();
        }catch(Exception e){
            System.out.println("SQLException: " + e.getMessage());
        }
    }
}
