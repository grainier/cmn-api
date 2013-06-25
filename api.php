<?php

require_once 'db_config.php'; // Import db_config.php

$errors = 0; // Error flag


/*
 * Trying to connect to mysql server.
 * Output Temporary error if unable to.
 */
if (!@mysql_connect($sql_host, $sql_user, $sql_pass)) {
    $results = Array(
        'head' => Array(
            'status' => '0',
            'error_number' => '500',
            'error_message' => 'Temporary Error.' .
            'Cannot connect to the server, please try again later.'
        ),
        'body' => Array()
    );
    $errors = 1;
}

/*
 * Trying to enter the database.
 * Output Temporary error if unable to.'
 */
if (!@mysql_select_db($sql_name)) {
    $results = Array(
        'head' => Array(
            'status' => '0',
            'error_number' => '500',
            'error_message' => 'Temporary Error.' .
            'Cannot connect to the database, please try again later.'
        ),
        'body' => Array()
    );
    $errors = 1;
}

/*
 * Break down the request
 */
$request = $_SERVER['REQUEST_URI']; // this would be /show/users/abc.json
$request_parts = explode('/', $_GET['url']); // array('show','users','abc')
$file_type = $_GET['type'];

/*
 * If no errors were found during connection
 * let's proceed with out queries
 */
if (!$errors)
    switch ($request_parts[0]) {
        /*
         * To retrieve values from the server
         */
        case 'get' :
            switch ($request_parts[1]) {
                /*
                 * Patients details
                 */
                case 'patient' :
                    if ($request_parts[2] == 'all') { // All patients
                        $query = "SELECT * FROM " . $tb_patient;

                        if (!$go = @mysql_query($query)) {
                            $results = Array(
                                'head' => Array(
                                    'status' => '0',
                                    'error_number' => '604',
                                    'error_message' => 'Select Failed. ' .
                                    'Probably wrong id supplied.'
                                ),
                                'body' => Array()
                            );
                        } else {
                            $retrieve = mysql_query($query) or die(mysql_error());
                            $patients = array();
                            while ($row = mysql_fetch_assoc($retrieve)) {
                                $patients[] = $row;
                            }
                            $results = array('patients' => $patients);
                        }

                    } else { // Specific patient (ID)
                        $query = "SELECT * FROM " . $tb_patient . " WHERE `pa_id` = " . $request_parts[2];

                        if (!$go = @mysql_query($query)) {
                            $results = Array(
                                'head' => Array(
                                    'status' => '0',
                                    'error_number' => '604',
                                    'error_message' => 'Select Failed. ' .
                                    'Probably invalid id supplied.'
                                ),
                                'body' => Array()
                            );
                        } else {
                            $retrieve_info = mysql_query($query) or die(mysql_error());
                            $patient = array();
                            while ($row_info = mysql_fetch_assoc($retrieve_info)) {

                                $patient['name'] =  $row_info['name'];

                                $patient['pa_id'] =  $row_info['pa_id'];

                                $patient['dob'] =  $row_info['dob'];

                                $patient['address'] =  $row_info['address'];

                                $patient['gender'] =  $row_info['gender'];

                                $patient['telno'] =  $row_info['telno'];

                                $query_prescriptions = "SELECT * FROM " . $tb_prescription . " WHERE `pa_id` = " . $row_info['pa_id'];

                                $retrieve_prescriptions = mysql_query($query_prescriptions) or die(mysql_error());

                                $prescriptions = array();

                                while ($row_prescription = mysql_fetch_assoc($retrieve_prescriptions)) {
                                    $prescriptions[] = $row_prescription;
                                }

                                $patient['prescriptions'] = $prescriptions;
                            }

                            $results = array('patient' => $patient);
                        }
                    }
                    break;

                /*
                 * Doctor's details
                 */
                case 'doctor' :
                    break;

                /*
                 * Drug's details
                 */
                case 'drug' :
                    if ($request_parts[2] == 'all') // All drugs
                    $query = "SELECT * FROM " . $tb_drug;
                    else // Specific prescription (ID)
                    $query = "SELECT * FROM " . $tb_contain . " WHERE `pr_id` = " . $request_parts[2];

                    if (!$go = @mysql_query($query)) {
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '604',
                                'error_message' => 'Select Failed. ' .
                                'Probably wrong id supplied.'
                            ),
                            'body' => Array()
                        );
                    } else {
                        $retrieve = mysql_query($query) or die(mysql_error());
                        $drug = array();
                        while ($row = mysql_fetch_assoc($retrieve)) {
                            $drug[] = $row;
                        }
                        $results = array('drug' => $drug);
                    }
                    break;

                /*
                 * Alergy details
                 */
                case 'alergy' :

                    $query = "SELECT `dr_id` FROM " . $tb_alergy . " WHERE `pa_id` = " . $request_parts[2];

                    if (!$go = @mysql_query($query)) {
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '604',
                                'error_message' => 'Select Failed. ' .
                                'Probably wrong id supplied.'
                            ),
                            'body' => Array()
                        );
                    } else {
                        $retrieve = mysql_query($query) or die(mysql_error());
                        $alergy = array();
                        while ($row = mysql_fetch_assoc($retrieve)) {
                            $alergy[] = $row;
                        }
                        $results = array('alergy' => $alergy);
                    }
                    break;

                /*
                 * Adverse drugs details
                 */
                case 'adverse' :
                    $query = "SELECT `dr_id` FROM " . $tb_adverse . " WHERE `pa_id` = " . $request_parts[2];

                    if (!$go = @mysql_query($query)) {
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '604',
                                'error_message' => 'Select Failed. ' .
                                'Probably wrong id supplied.'
                            ),
                            'body' => Array()
                        );
                    } else {
                        $retrieve = mysql_query($query) or die(mysql_error());
                        $adverse = array();
                        while ($row = mysql_fetch_assoc($retrieve)) {
                            $adverse[] = $row;
                        }
                        $results = array('adverse' => $adverse);
                    }
                    break;

                /*
                 * Prescription's details
                 */
                case 'prescription' :

                    $query = "SELECT * FROM " . $tb_prescription . " WHERE `pr_id` = " . $request_parts[2];

                    if (!$go = @mysql_query($query)) {
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '604',
                                'error_message' => 'Select Failed. ' .
                                'Probably invalid id supplied***.'
                            ),
                            'body' => Array()
                        );
                    } else {

                        $retrieve_info = mysql_query($query) or die(mysql_error());
                        $prescription = array();
                        while ($row_info = mysql_fetch_assoc($retrieve_info)) {

                            $prescription['pr_id'] =  $row_info['pr_id'];

                            $prescription['pa_id'] =  $row_info['pa_id'];

                            $prescription['do_id'] =  $row_info['do_id'];

                            $prescription['ph_id'] =  $row_info['ph_id'];

                            $prescription['is_date'] =  $row_info['is_date'];

                            $prescription['dr_date'] =  $row_info['dr_date'];

                            $query_drugs = "SELECT `contain`.`dr_id` FROM `contain` INNER JOIN `prescription` ON `contain`.`pr_id`=`prescription`.`pr_id` WHERE `prescription`.`pr_id`= " . $row_info['pr_id'];

                            $retrieve_drugs = mysql_query($query_drugs) or die(mysql_error());

                            $drugs = array();

                            while ($row_drugs = mysql_fetch_assoc($retrieve_drugs)) {

                                $query_drug = "SELECT * FROM " . $tb_drug . " WHERE `dr_id` = " . $row_drugs['dr_id'];

                                $retrieve_drug = mysql_query($query_drug) or die(mysql_error());

                                while ($row_drug = mysql_fetch_assoc($retrieve_drug)) {
                                    $drugs[] = $row_drug;
                                }
                            }

                            $prescription['drugs'] = $drugs;
                        }

                        $results = array('prescription' => $prescription);

                    }
                    break;

                /*
                 * User details
                 */
                case 'user' :
                    break;

                /*
                 * Pharmacy details
                 */
                case 'pharmacy' :
                    if ($request_parts[2] == 'all') // All pharmacies
                    $query = "SELECT * FROM " . $tb_pharmacy;
                    else // Specific Pharmacy (ID)
                    $query = "SELECT * FROM " . $tb_pharmacy . " WHERE `ph_id` = " . $request_parts[2];

                    if (!$go = @mysql_query($query)) {
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '604',
                                'error_message' => 'Select Failed. ' .
                                'Probably wrong id supplied.'
                            ),
                            'body' => Array()
                        );
                    } else {
                        $retrieve = mysql_query($query) or die(mysql_error());
                        $pharmacy = array();
                        while ($row = mysql_fetch_assoc($retrieve)) {
                            $pharmacy[] = $row;
                        }
                        $results = array('pharmacy' => $pharmacy);
                    }
                    break;

                /*
                 * Drugs in Prescription details
                 */
                case 'contain' :
                    break;
            }
            break;

        /*
         * To add new values to the server
         */
        case 'post' :
            switch ($request_parts[1]) {
                /*
                 * Patients details
                 */
                case 'patient' :
                    $query = "INSERT INTO " . $tb_patient . " (name, dob, address, gender, telno) VALUES ('$request_parts[2]', '$request_parts[3]', '$request_parts[4]', '$request_parts[5]', '$request_parts[6]')";

                    if (!$go = @mysql_query($query))
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '601',
                                'error_message' => 'Duplicate Entry.' .
                                '			Patient already present.'
                            ),
                            'body' => Array()
                        );
                    else {
                        $return = @mysql_insert_id();
                        $results = Array(
                            'head' => Array(
                                'status' => 1
                            ),
                            'body' => Array(
                                'id' => $return
                            )
                        );
                    }
                    break;
                /*
                 * Doctor's details
                 */
                case 'doctor' :
                    break;

                /*
                 * Drug's details
                 */
                case 'drug' :
                    break;

                /*
                 * Alergy details
                 */
                case 'alergy' :
                    break;

                /*
                 * Adverse drugs details
                 */
                case 'adverse' :
                    break;

                /*
                 * Prescription's details
                 */
                case 'prescription' :
                    // api/post/prescription/patient_id/doctor_id/drug1/drug2/drug3/..../drugn.json

                    $t = time();
                    $date = (date("Ymd", $t));
                    $query = "INSERT INTO " . $tb_prescription . " (pa_id, do_id, is_date) VALUES ($request_parts[2], $request_parts[3], $date)";

                    if (!$go = @mysql_query($query))
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '601',
                                'error_message' => 'Faild to add prescription.'
                            ),
                            'body' => Array()
                        );
                    else {
                        $return = @mysql_insert_id();

                        $drug_params = "INSERT INTO " . $tb_contain . " (pr_id, dr_id) VALUES ";
                        for ($i = 4; $i < count($request_parts); $i++) { // start from 4 because drug params begins from index 3
                            // first segment is always same pr_id, second is the dr_id
                            $drug_params .= "($return , " . $request_parts[$i] . ")";
                            if ($i + 1 < count($request_parts)) {
                                $drug_params .= ", ";
                            } else {
                                $drug_params .= " ";
                            }
                        }

                        if (!$go = @mysql_query($drug_params))
                            $results = Array(
                                'head' => Array(
                                    'status' => '0',
                                    'error_number' => '601',
                                    'error_message' => 'Faild to add drugs.'
                                ),
                                'body' => Array()
                            );

                        else {
                            $results = Array(
                                'head' => Array(
                                    'status' => 1
                                ),
                                'body' => Array(
                                    'id' => $return
                                )
                            );
                        }
                    }
                    break;

                /*
                 * User details
                 */
                case 'user' :
                    break;

                /*
                 * Pharmacy details
                 */
                case 'pharmacy' :
                    break;
            }
            break;

        /*
         * To update values on the server
         */
        case 'update' :
            switch ($request_parts[1]) {
                /*
                 * Patients details
                 */
                case 'patient' :

                    $update_params = ""; // update string ie: "name = 'grainier', dob = '19910919', gender = 'male'"         

                    for ($i = 3; $i < count($request_parts); $i = $i + 2) { // start from 3 because update params begins from index 3
                        // first segment is the column name, second is the value
                        $update_params .= $request_parts[$i] . " = '" . $request_parts[$i + 1] . "'";
                        if ($i + 2 < count($request_parts)) {
                            $update_params .= ", ";
                        } else {
                            $update_params .= " ";
                        }
                    }

                    $query = "UPDATE " . $tb_patient . " SET " . $update_params . " WHERE pa_id = $request_parts[2]";
                    if (!@mysql_query($query))
                        $results = Array(
                            'head' => Array(
                                'status' => '0',
                                'error_number' => '602',
                                'error_message' => 'Update Failed. ' .
                                'Probably wrong id supplied.'
                            ),
                            'body' => Array()
                        );
                    else {
                        $query = "SELECT * FROM " . $tb_patient . " WHERE `pa_id` = " . $request_parts[2] . " LIMIT 1";

                        if (!$go = @mysql_query($query)) {
                            $results = Array(
                                'head' => Array(
                                    'status' => '0',
                                    'error_number' => '603',
                                    'error_message' => 'Select Failed. ' .
                                    'Probably wrong id supplied.'
                                ),
                                'body' => Array()
                            );
                        } else {
                            $fetch = mysql_fetch_row($go);
                            $return = $fetch[0];
                            $results = Array(
                                'head' => Array(
                                    'status' => 1
                                ),
                                'body' => Array(
                                    'id' => $return
                                )
                            );
                        }
                    }
                    break;
                /*
                 * Doctor's details
                 */
                case 'doctor' :
                    break;

                /*
                 * Drug's details
                 */
                case 'drug' :
                    break;

                /*
                 * Alergy details
                 */
                case 'alergy' :
                    break;

                /*
                 * Adverse drugs details
                 */
                case 'adverse' :
                    break;

                /*
                 * Prescription's details
                 */
                case 'prescription' :
                    if ($request_parts[2] == 'issue') { // Issue drugs for the prescription
                        $t = time();
                        $date = (date("Ymd", $t));

                        $update_params = "ph_id = $request_parts[4], dr_date = $date";

                        $query = "UPDATE " . $tb_prescription . " SET " . $update_params . " WHERE pr_id = $request_parts[3]";
                        if (!@mysql_query($query))
                            $results = Array(
                                'head' => Array(
                                    'status' => '0',
                                    'error_number' => '602',
                                    'error_message' => 'Update Failed. ' .
                                    'Probably wrong id supplied.'
                                ),
                                'body' => Array()
                            );
                        else {
                            $query = "SELECT * FROM " . $tb_prescription . " WHERE `pr_id` = " . $request_parts[3] . " LIMIT 1";

                            if (!$go = @mysql_query($query)) {
                                $results = Array(
                                    'head' => Array(
                                        'status' => '0',
                                        'error_number' => '603',
                                        'error_message' => 'Select Failed. ' .
                                        'Probably wrong id supplied.'
                                    ),
                                    'body' => Array()
                                );
                            } else {
                                $fetch = mysql_fetch_row($go);
                                $return = $fetch[0];
                                $results = Array(
                                    'head' => Array(
                                        'status' => 1
                                    ),
                                    'body' => Array(
                                        'id' => $return
                                    )
                                );
                            }
                        }
                    }
                    break;
                /*
                 * User details
                 */
                case 'user' :
                    break;

                /*
                 * Pharmacy details
                 */
                case 'pharmacy' :
                    break;

                /*
                 * Drugs in Prescription details
                 */
                case 'contain' :
                    break;
            }
            break;
        /*
         * To delete records on the server
         */
        case 'delete' :
            switch ($request_parts[1]) {
                /*
                 * Patients details
                 */
                case 'patient' :
                    $query = "DELETE FROM " . $tb_patient . " WHERE pa_id= $request_parts[2]";
                    break;

                /*
                 * Doctor's details
                 */
                case 'doctor' :
                    $query = "DELETE FROM " . $tb_doctor . " WHERE do_id= $request_parts[2]";
                    break;

                /*
                 * Drug's details
                 */
                case 'drug' :
                    $query = "DELETE FROM " . $tb_drug . " WHERE dr_id= $request_parts[2]";
                    break;

                /*
                 * Alergy details
                 */
                case 'alergy' :
                    $query = "DELETE FROM " . $tb_alergy . " WHERE al_id= $request_parts[2]";
                    break;

                /*
                 * Adverse drugs details
                 */
                case 'adverse' :
                    $query = "DELETE FROM " . $tb_adverse . " WHERE ad_id= $request_parts[2]";
                    break;

                /*
                 * Prescription's details
                 */
                case 'prescription' :
                    $query = "DELETE FROM " . $tb_prescription . " WHERE pr_id= $request_parts[2]";
                    break;

                /*
                 * User details
                 */
                case 'user' :
                    $query = "DELETE FROM " . $tb_user . " WHERE us_id= $request_parts[2]";
                    break;

                /*
                 * Pharmacy details
                 */
                case 'pharmacy' :
                    $query = "DELETE FROM " . $tb_pharmacy . " WHERE ph_id= $request_parts[2]";
                    break;

                /*
                 * Drugs in Prescription details
                 */
                case 'contain' :
                    $query = "DELETE FROM " . $tb_contain . " WHERE co_id= $request_parts[2]";
                    break;
            }

            if (!$go = @mysql_query($query))
                $results = Array(
                    'head' => Array(
                        'status' => '0',
                        'error_number' => '601',
                        'error_message' => 'Entry doesn\'t exist.'
                    ),
                    'body' => Array()
                );
            else {
                $return = @mysql_insert_id();
                $results = Array(
                    'head' => Array(
                        'status' => 1
                    ),
                    'body' => Array(
                        'id' => $return
                    )
                );
            }
            break;

        /*
         * To delete records on the server
         */
        case 'auth' :
            $query = "SELECT type, us_id FROM " . $tb_user . " WHERE user='$request_parts[1]' AND pass='$request_parts[2]'";

            if (!$go = @mysql_query($query)) {
                $results = Array(
                    'head' => Array(
                        'status' => '0',
                        'error_number' => '604',
                        'error_message' => 'Auth Failed. '
                    ),
                    'body' => Array()
                );
            } else {
                $retrieve = mysql_query($query) or die(mysql_error());
                $auth = array();
                while ($row = mysql_fetch_assoc($retrieve)) {
                    $auth[] = $row;
                }
                $results = array('auth' => $auth);
            }
            break;
    }
mysql_close();


/*
 * Output based on request
 */
switch ($file_type) {
    case 'json':
        returnJSON($results);
        break;
    case 'xml':
        returnXML($results);
        break;
    default:
        echo $results;
        break;
}

function returnJSON($data)
{
    @header("content-type: text/json charset=utf-8");
    echo json_encode($data);
}

function returnXML($data)
{
    @header("content-type: text/xml charset=utf-8");
    $xml = new XmlWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');
    $xml->startElement('callback');
    $xml->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
    $xml->writeAttribute('xsi:noNamespaceSchemaLocation', 'schema.xsd');

    writeXML($xml, $data);

    $xml->endElement();
    echo $xml->outputMemory(true);
}

function writeXML(XMLWriter $xml, $data)
{
    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $xml->startElement($key);
            writeXML($xml, $value);
            $xml->endElement();
            continue;
        }
        $xml->writeElement($key, $value);
    }
}

?>