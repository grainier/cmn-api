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

http://{YOURDOMAIN}/{YOURPATH}/TYPE/FUNCTION/patient/all

	
TYPE:
	json = output result as json
	xml  = output result as xml


FUNCTION:
	get  = get wallpapers' infos
	post = write values into the website, like new favourites ecc... [not currently available]
	update = get infos about queries, like total wallpapers number ecc... [not currently available]

	
WHAT:
	latest         = get wallpapers ordered by latest added
	popular        = get wallpapers ordered by most viewed
	top_downloaded = get wallpapers ordered by most downloaded
	top_favourited = get wallpapers ordered by most favourited
	top_rated      = get wallpapers ordered by highest rated
	random         = get wallpapers ordered randomly
	category       = get wallpapers from a category ordered by latest added
	tag            = get wallpapers tagged with the required tag ordered by latest added
	color          = get wallpapers that have a required main color ordered by latest added
	member         = get member's uploaded wallpapers ordered by latest added
	fav_cat        = get wallpapers from a member's favourites category ordered by latest favourited
	search         = do a custom search and return wallpapers ordered by latest added [not currently available]
	size           = get wallpapers that have a minimum width and a minimum height ordered by latest added

==============================================================================================
View
----------------------------------------------------------------------------------------------
Patient :   example.com/api/get/patient/all.json    <= all patients
            example.com/api/get/patient/1.json      <= specific patients (from id)


Drug    :

==============================================================================================
Add
----------------------------------------------------------------------------------------------
Patient :   example.com/api/post/patient/grainier/19910919/address/male/716122384.json


Drug    :

==============================================================================================
Update
----------------------------------------------------------------------------------------------
Patient :   example.com/api/post/patient/grainier/19910919/address/male/716122384.json


Drug    :
