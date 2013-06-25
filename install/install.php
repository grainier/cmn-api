<?php
/*
 * Import db_config.php
 */
require_once '../db_config.php';


/*
 * Connect to HOST
 */
$con = mysql_connect($sql_host, $sql_user, $sql_pass);
if (!$con) {
    die('Could not connect: ' . mysql_error());
}


/*
 * Create database
 */
if (!mysql_query("CREATE DATABASE " . $sql_name, $con)) {
    echo "Error creating database: " . mysql_error();
}


/*
 * Create tables
 */
mysql_select_db($sql_name, $con);

$sql_1 = "CREATE TABLE " . $tb_patient . " (
        pa_id int NOT NULL AUTO_INCREMENT,
        name varchar(50),
        dob varchar(8),
        address text,
        gender varchar(10),
        telno varchar(15),
        PRIMARY KEY(pa_id)
        )";

$sql_2 = "CREATE TABLE " . $tb_doctor . " (
        do_id int NOT NULL AUTO_INCREMENT,
        pa_id int NOT NULL,
        reg_no varchar(10),
        PRIMARY KEY(do_id)
        )";

$sql_3 = "CREATE TABLE " . $tb_drug . " (
        dr_id int NOT NULL AUTO_INCREMENT,
        name varchar(20),
        d_time int NOT NULL,
        d_qnt int NOT NULL,
        PRIMARY KEY(dr_id)
        )";

$sql_4 = "CREATE TABLE " . $tb_alergy . " (
        pa_id int NOT NULL,       
        dr_id int NOT NULL,
        PRIMARY KEY(pa_id, dr_id)
        )";

$sql_5 = "CREATE TABLE " . $tb_adverse . " (
        dr_id1 int NOT NULL,       
        dr_id2 int NOT NULL,
        PRIMARY KEY(dr_id1, dr_id2)
        )";

$sql_6 = "CREATE TABLE " . $tb_prescription . " (
        pr_id int NOT NULL AUTO_INCREMENT,
        pa_id int NOT NULL,       
        do_id int NOT NULL,
        ph_id int NOT NULL,
        is_date int NOT NULL,
        dr_date int NOT NULL,
        PRIMARY KEY(pr_id)
        )";

$sql_7 = "CREATE TABLE " . $tb_user . " (
        user varchar(20),
        pass varchar(20),
        type int,
        us_id int NOT NULL,
        PRIMARY KEY(user)
        )";

$sql_8 = "CREATE TABLE " . $tb_pharmacy . " (
        ph_id int NOT NULL AUTO_INCREMENT,
        name varchar(20),
        address varchar(20),
        telno varchar(20),
        PRIMARY KEY(ph_id)
        )";

$sql_9 = "CREATE TABLE " . $tb_contain . " (
        pr_id int NOT NULL,       
        dr_id int NOT NULL,
        PRIMARY KEY(pr_id, dr_id)
        )";
/**
 * Dosage Time Constants
 * =====================
 * 1: Morning (M)
 * 2: Day (D)
 * 3: M&D
 * 4: Night (N)
 * 5: MN
 * 6: DN
 * 7: MDN
 * 8: Hourly
 */

/*
 * Add stub records
 */
$sql_10 = "INSERT INTO " . $tb_patient . " (name, dob, address, gender, telno)
                VALUES
                        ('Grainier', '19910919', '51 Tudella Ja-ela', 'male', '0716122384'),
                        ('Yehan', '19910819', '23 Minuwangoda', 'male', '0716654845'),
                        ('Anushka', '19810819', '28 Minuwangoda', 'male', '0714454845'),
                        ('Buddhi', '19920213', '23 Galle', 'male', '0712454844'),
                        ('Praminda', '19020318', '51 Pallewela', 'male', '0716165484')";

$sql_11 = "INSERT INTO " . $tb_doctor . " (pa_id, reg_no)
                VALUES
                        (1, 0000001),
                        (2, 0000002)";

$sql_12 = "INSERT INTO " . $tb_drug . " (name, dosage)
                VALUES
                        ('Amoxicillin', 7),
                        ('Prednisolone', 1),
                        ('Penicillin', 4),
                        ('Morphine', 4),
                        ('Paracetamol', 2)";

$sql_13 = "INSERT INTO " . $tb_alergy . " (pa_id, dr_id)
                VALUES
                        (3, 1),
                        (1, 1),
                        (4, 2),
                        (4, 4),
                        (2, 2),
                        (5, 4)";

$sql_14 = "INSERT INTO " . $tb_adverse . " (dr_id1, dr_id2)
                VALUES
                        (1, 2),
                        (2, 3),
                        (3, 2),
                        (4, 5),
                        (5, 1),
                        (5, 4)";

$sql_15 = "INSERT INTO " . $tb_prescription . " (pa_id, do_id, ph_id, is_date, dr_date)
                VALUES
                        (1, 1, 1, 20120528,20120529),
                        (4, 2, 2, 20120315,20120315),
                        (5, 2, 1, 20120102,20120103),
                        (3, 2, 2, 20120430,20120501),
                        (4, 1, 3, 20120820,0),
                        (2, 1, 3, 20120919,0)";

$sql_16 = "INSERT INTO " . $tb_user . " (user, pass, type, us_id)
                VALUES
                        ('grainier', '001', 2, 1),
                        ('yehan', '001', 2, 2),
                        ('anushka', '001', 1, 3),
                        ('buddhi', '001', 1, 4),
                        ('praminda', '001', 1, 5),
                        ('pharmacy1', '001', 3, 1),
                        ('pharmacy2', '001', 3, 2),
                        ('pharmacy3', '001', 3, 3)";


$sql_17 = "INSERT INTO " . $tb_pharmacy . " (name, address, telno)
                VALUES
                        ('City Pharmacy', '21 Jaela', '0112235123'),
                        ('XY Pharmacy', '35 Colombo', '0312245632'),
                        ('CSC Pharmacy', '47 Gampaha', '0112233554')";


$sql_18 = "INSERT INTO " . $tb_contain . " (pr_id, dr_id)
                VALUES
                        (1, 5),
                        (2, 5),
                        (3, 2),
                        (4, 3),
                        (5, 2),
                        (6, 1),
                        (1, 2),
                        (2, 3),
                        (3, 4),
                        (4, 5),
                        (5, 5),
                        (6, 5)";


/*
 * Execute query
 */
mysql_query($sql_1, $con);
mysql_query($sql_2, $con);
mysql_query($sql_3, $con);
mysql_query($sql_4, $con);
mysql_query($sql_5, $con);
mysql_query($sql_6, $con);
mysql_query($sql_7, $con);
mysql_query($sql_8, $con);
mysql_query($sql_9, $con);
mysql_query($sql_10, $con);
mysql_query($sql_11, $con);
mysql_query($sql_12, $con);
mysql_query($sql_13, $con);
mysql_query($sql_14, $con);
mysql_query($sql_15, $con);
mysql_query($sql_16, $con);
mysql_query($sql_17, $con);
mysql_query($sql_18, $con);
//        if (!mysql_query($sql_10,$con))
//        {
//            echo "Error adding records: " . mysql_error();
//        }

/*
 * Close connection
 */
mysql_close($con);
echo "--- Done ---";
?>
