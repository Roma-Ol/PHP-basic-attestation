Please, follow the instruction above in order to open the project correctly.

1.  $ cd *ur project directory*       		   		// Be sure to run all the commands from the project root
2.  $ git pull origin release-candidate		   		// Pull the latest branch from the GitHub.
3.  Copy settings.local.php to web/sites/default	// No explanation, just necessary
4.  Copy settings.php to web/sites/default       	// No explanation, just necessary
5.  $ fin up         				  				// Start project services
6.  $ fin composer install        	  	   			// Install necessary dependencies.
7.  $ fin db import database.sql        			// Import the database. (NOT TODAY- USE ONLY IF ONE DAY
													// THE DEVELOPER WILL PROVIDE THE DB FUNCTIONALITY).
8.  $ fin drush cr        		   	  				// Clear the cache.
9.  Follow http://module-lvl-1-1/form-main  		// To see the perfection)))0)))
10. Enjoy           			   	  				// The most important part.

--------------------------OR--------------------------

U can just copy the module folder (web/modules/custom/guestbook) into ur project custom! modules folder.
And follow http://*ur project name*/form-main to see the perfection.

