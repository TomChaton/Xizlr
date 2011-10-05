/*
These are default settings when you start up Xizlr for the first time.
Change the values using the install and admin scripts or in mongo itself 
*/

/*
Note to ken. These values go into mongo
*/

{
	"strApplicationName":"Xizlr",
	"arrEnvironment":{
		"bolDevEnv":true,
		"strDevEmail":"admin@localhost",
		"bolDebugMode":true,
		"strBaseDir":"/etc/xizlr",
		"strMainRDMS":"MySQL",
		"arrFileStorage":{
			"strType":"disk",
			"strLocation":"/var/lib/xilzr",
			"bolCacheFiles":true,
			"intCacheTime":10,
			"arrCredentials":{
				"strUsername":"",
				"strPassword":"",
				"strPassKey":""
			}
		},
		"arrApplications":{
			
		},
		"arrPageHandles":{
			"Index":"Index",
			"AccessDenied":"AccessDenied",
			"Login":"Login"
		}
	},
	"arrLocalMachine":{
		"strMailServer" : "localhost",
		"strDevReturnDomain" : "localhost"
	}
}
