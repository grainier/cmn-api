----------------------------------------------------------------------------------------------
REQUIREMENTS:
----------------------------------------------------------------------------------------------

  1. Apache, Php and Mysql installed
	2. Apache needs mod_rewrite enabled
	3. Php needs json_decode and xmlwriter

----------------------------------------------------------------------------------------------	
CONFIGURATION:
----------------------------------------------------------------------------------------------

	1. Configure the db_config.php
	2. Run http://{YOURDOMAIN}/{YOURPATH}/install/index.php
	3. Be sure to copy the hidden .htaccess file in the same folder of api.php

----------------------------------------------------------------------------------------------
RUN:
----------------------------------------------------------------------------------------------
	
	1. Try to access this address (replace your domain and path)
	
		http://{YOURDOMAIN}/{YOURPATH}/get.xml?name=Memento

----------------------------------------------------------------------------------------------
TRUBLESHOTING :
----------------------------------------------------------------------------------------------

	If above address gives 404 not found and you're sure about the path 
	please try this alternative address 
		
		http://{YOURDOMAIN}/{YOURPATH}/api.php?method=get&format=xml&name=Memento
	
	If this works, you probably need to better configure your apache
	to make url_rewrite working


----------------------------------------------------------------------------------------------
STRUCTURE : 
----------------------------------------------------------------------------------------------

http://{YOURDOMAIN}/{YOURPATH}/api/FUNCTION/patient/all.TYPE

	
TYPE:
	json = output result as json
	xml  = output result as xml

FUNCTION:
	get  = retrieve content
	post = post content
	update = update content

==============================================================================================
GET
----------------------------------------------------------------------------------------------
ie :   example.com/api/get/patient/all.json    <= all patients
       example.com/api/get/patient/1.json      <= specific patients (from id)

api/get/patient/all.json

api/get/patient/1.json		1 => patient ID

api/get/drug/all.json

api/get/drug/1.json		1 => patient ID

api/get/alergy/1.json		1 => patient ID

api/get/adverse/1.json		1 => drug ID

api/get/pharmacy/all.json

api/get/pharmacy/1.json		1 => pharmacy ID

api/get/prescription/1.json 	1 => patient ID

==============================================================================================
POST
----------------------------------------------------------------------------------------------
ie :   example.com/api/post/patient/grainier/19910919/address/male/716122384.json

api/post/patient/name/dob/address/gender/telno.json

api/post/prescription/patient_id/doctor_id/drug1/drug2/drug3/..../drugn.json

==============================================================================================
UPDATE
----------------------------------------------------------------------------------------------
ie :   example.com/api/post/patient/grainier/19910919/address/male/716122384.json

api/update/patient/4/name/anushka/dob/19951012/gender/female.json	4 => patient id

api/update/prescription/issue/4/2.json 	4 => prescription_id/ 2 => pharmacy_id

==============================================================================================
AUTH
----------------------------------------------------------------------------------------------
api/auth/grainier/001.json	grainier => user name / 001 => password
