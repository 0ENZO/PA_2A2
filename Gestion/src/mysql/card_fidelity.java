package mysql;

import javax.swing.*;
import javax.swing.JTable;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.*;


public class card_fidelity extends JFrame {
    JFrame card;
    JPanel PannelConnexion,headPanel;
    JPanel downPanel,downPanelLeft,downPanelRight;
    JSplitPane splitPane;
    JTable table1;
    JScrollPane ContainTable;
    JLabel labelTitle;
    JLabel labelId,labelPoint;
    JTextField idInfo,pointInfo;
    JSeparator separator;
    JButton addButton,removeButton,setButton,deleteButton,refreshButton;

    int id,points,getPoints,totalPoint;



    public static void main(String[] args) throws SQLException, ClassNotFoundException {
        card_fidelity test = new card_fidelity();
        test.affichageFidelity();
    }

    public void affichageFidelity() throws SQLException, ClassNotFoundException {
        card= new JFrame("App");
        card.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        headPanel = new JPanel();
        headPanel.setLayout(new GridBagLayout());
        labelTitle = new JLabel("Gestion des cartes de fidélités");
        labelTitle.setFont(new Font("Century Gothic", Font.PLAIN, 24) );
        labelTitle.setForeground(Color.white);
        headPanel.add(labelTitle);
        headPanel.setBorder(BorderFactory.createEmptyBorder(20, 10, 20, 10));
        card.add(headPanel,BorderLayout.PAGE_START);
        headPanel.setBackground(Color.decode("248148006"));
        table();
        modification();
        this.card.setSize(700,450);
        this.card.setVisible(true);

    }

    public void table() throws SQLException, ClassNotFoundException {
        String[] titles={"id","email", "first name", "last name","Points"};
        DefaultTableModel tableModel = new DefaultTableModel(titles, 0);
        tableModel = updateTable(titles);
        table1 = new JTable(tableModel);
        table1.setPreferredScrollableViewportSize(new Dimension(450, 150));
        table1.setFillsViewportHeight(true);
        DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment( SwingConstants.CENTER );

        for(int x=0;x<5;x++){
            table1.getColumnModel().getColumn(x).setCellRenderer( centerRenderer );
        }

        ContainTable = new JScrollPane(table1,JScrollPane.VERTICAL_SCROLLBAR_AS_NEEDED,JScrollPane.HORIZONTAL_SCROLLBAR_NEVER);
        PannelConnexion = new JPanel();
        PannelConnexion.add(ContainTable);
        refreshButton = new JButton("Refresh");
        refreshButton.setFont(new Font("Century Gothic", Font.PLAIN, 12) );
        PannelConnexion.add(refreshButton);
        PannelConnexion.setBackground(Color.decode("003023242"));
        card.add(PannelConnexion,BorderLayout.CENTER);
    }

    public DefaultTableModel updateTable(String[] titles) throws ClassNotFoundException, SQLException {
        DefaultTableModel tableModel = new DefaultTableModel(titles, 0);

        Class.forName("com.mysql.jdbc.Driver");
        Connection con= DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
        PreparedStatement statement = con.prepareStatement("select * from user");
        ResultSet rs=statement.executeQuery();

        while (rs.next()) {
            String id = String.valueOf(rs.getInt("id"));
            String email = rs.getString("email");
            String firstName = rs.getString("first_name");
            String lastName = rs.getString("last_name");
            String points = String.valueOf(rs.getInt("euro_points"));


            // create a single array of one row's worth of data
            String[] data = { id, email, firstName,lastName,points } ;

            // and add this row of data into the table model
            tableModel.addRow(data);
        }
        con.close();
        return tableModel;
    }
    private void modification() {

        downPanel = new JPanel();
        downPanel.setBackground(Color.decode("248148006"));
        downPanel.setBorder(BorderFactory.createEmptyBorder(10, 10, 10, 10));
        downPanelLeft = new JPanel();
        downPanelLeft.setBackground(Color.decode("248148006"));
        //downPanelLeft.setBorder(BorderFactory.createEmptyBorder(0, 10, -20, 10));
        downPanelRight = new JPanel();
        downPanelRight.setBackground(Color.decode("248148006"));
        downPanelRight.setBorder(BorderFactory.createEmptyBorder(-10, 10, 0, 10));
        separator = new JSeparator();
        separator.setOrientation(SwingConstants.HORIZONTAL);
        separator.setForeground(Color.decode("248148006"));
        separator.setBorder(BorderFactory.createEmptyBorder(-20, 10, -30, 10));




        labelId = new JLabel("Id:");
        labelId.setFont(new Font("Century Gothic", Font.PLAIN, 12) );
        labelId.setForeground(Color.white);
        downPanelLeft.add(labelId);
        idInfo = new JTextField(5);
        downPanelLeft.add(idInfo);

        labelPoint = new JLabel("Points:");
        labelPoint.setFont(new Font("Century Gothic", Font.PLAIN, 12) );
        labelPoint.setForeground(Color.white);
        downPanelLeft.add(labelPoint);
        pointInfo = new JTextField(5);
        downPanelLeft.add(pointInfo);

        addButton = new JButton("Ajouter les points");
        addButton.setFont(new Font("Century Gothic", Font.PLAIN, 12) );
        removeButton = new JButton("enlever les points");
        removeButton.setFont(new Font("Century Gothic", Font.PLAIN, 12) );
        setButton = new JButton("Définir les points");
        setButton.setFont(new Font("Century Gothic", Font.PLAIN, 12) );
        deleteButton = new JButton("reset les points");
        setButton.setFont(new Font("Century Gothic", Font.PLAIN, 12) );

        downPanelRight.add(addButton);
        downPanelRight.add(removeButton);
        downPanelRight.add(setButton);
        downPanelRight.add(deleteButton);

        downPanel.add(downPanelLeft);
        downPanel.add(separator);
        downPanel.add(downPanelRight);
        downPanel.setLayout(new GridLayout(0,1));
        card.add(downPanel,BorderLayout.PAGE_END);




        addButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                id = Integer.parseInt(idInfo.getText());
                points = Integer.parseInt(pointInfo.getText());

                try {
                    Class.forName("com.mysql.jdbc.Driver");
                    Connection con = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                    PreparedStatement statement = con.prepareStatement("select * from user where id = ?");
                    statement.setInt(1, id);
                    ResultSet rs = statement.executeQuery();


                    if (rs.next()) {
                        getPoints = rs.getInt("euro_points");

                        try {
                            Connection conn = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                            PreparedStatement statementSuite = conn.prepareStatement("update user set euro_points =  ? where id = ?");
                            statementSuite.setInt(1, points + getPoints);
                            statementSuite.setInt(2, id);
                            statementSuite.executeUpdate();

                            conn.close();
                        } catch (Exception error) {
                            System.out.println("SQLException2: " + error.getMessage());
                        }
                    }
                    con.close();
                } catch (Exception error) {
                    System.out.println("SQLException: " + error.getMessage());
                }
                card.dispose();
                try {
                    main(null);
                } catch (SQLException throwables) {
                    throwables.printStackTrace();
                } catch (ClassNotFoundException classNotFoundException) {
                    classNotFoundException.printStackTrace();
                }
            }
        });


        removeButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                id = Integer.parseInt(idInfo.getText());
                points = Integer.parseInt(pointInfo.getText());

                try {
                    Class.forName("com.mysql.jdbc.Driver");
                    Connection con = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                    PreparedStatement statement = con.prepareStatement("select * from user where id = ?");
                    statement.setInt(1, id);
                    ResultSet rs = statement.executeQuery();


                    if (rs.next()) {
                        getPoints = rs.getInt("euro_points");
                        totalPoint = getPoints - points;
                        if(totalPoint < 0){
                            totalPoint = 0;
                        }

                        try {
                            Connection conn = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                            PreparedStatement statementSuite = conn.prepareStatement("update user set euro_points =  ? where id = ?");
                            statementSuite.setInt(1, totalPoint);
                            statementSuite.setInt(2, id);
                            statementSuite.executeUpdate();

                            conn.close();
                        } catch (Exception error) {
                            System.out.println("SQLException2: " + error.getMessage());
                        }
                    }
                    con.close();
                } catch (Exception error) {
                    System.out.println("SQLException: " + error.getMessage());
                }
                card.dispose();
                try {
                    main(null);
                } catch (SQLException throwables) {
                    throwables.printStackTrace();
                } catch (ClassNotFoundException classNotFoundException) {
                    classNotFoundException.printStackTrace();
                }
            }
        });

        setButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                id = Integer.parseInt(idInfo.getText());
                points = Integer.parseInt(pointInfo.getText());

                try {
                    Class.forName("com.mysql.jdbc.Driver");
                    Connection con = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                    PreparedStatement statement = con.prepareStatement("select * from user where id = ?");
                    statement.setInt(1, id);
                    ResultSet rs = statement.executeQuery();


                    if (rs.next()) {
                        try {
                            Connection conn = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                            PreparedStatement statementSuite = conn.prepareStatement("update user set euro_points =  ? where id = ?");
                            statementSuite.setInt(1, points);
                            statementSuite.setInt(2, id);
                            statementSuite.executeUpdate();

                            conn.close();
                        } catch (Exception error) {
                            System.out.println("SQLException2: " + error.getMessage());
                        }
                    }
                    con.close();
                } catch (Exception error) {
                    System.out.println("SQLException: " + error.getMessage());
                }
                card.dispose();
                try {
                    main(null);
                } catch (SQLException throwables) {
                    throwables.printStackTrace();
                } catch (ClassNotFoundException classNotFoundException) {
                    classNotFoundException.printStackTrace();
                }
            }
        });

        deleteButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                id = Integer.parseInt(idInfo.getText());

                try {
                    Class.forName("com.mysql.jdbc.Driver");
                    Connection con = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                    PreparedStatement statement = con.prepareStatement("select * from user where id = ?");
                    statement.setInt(1, id);
                    ResultSet rs = statement.executeQuery();


                    if (rs.next()) {
                        try {
                            Connection conn = DriverManager.getConnection("jdbc:mysql://127.0.0.1:3306/drivncook", "drivncook", "Kamalthebest!");
                            PreparedStatement statementSuite = conn.prepareStatement("update user set euro_points =  ? where id = ?");
                            statementSuite.setInt(1, 0);
                            statementSuite.setInt(2, id);
                            statementSuite.executeUpdate();

                            conn.close();
                        } catch (Exception error) {
                            System.out.println("SQLException2: " + error.getMessage());
                        }
                    }
                    con.close();
                } catch (Exception error) {
                    System.out.println("SQLException: " + error.getMessage());
                }
                card.dispose();
                try {
                    main(null);
                } catch (SQLException throwables) {
                    throwables.printStackTrace();
                } catch (ClassNotFoundException classNotFoundException) {
                    classNotFoundException.printStackTrace();
                }
            }
        });
    }




}
