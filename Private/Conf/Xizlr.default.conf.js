/*
These are default settings when you start up Xizlr for the first time.
Change the values using the install and admin scripts or in mongo itself 
*/

/*
Note to ken. These values go into mongo
*/

arrXizlr = {
	arrEnvironment:{
		bolDevEnv:true,
		strDevEmail:'admin@localhost',
		bolDebugMode:true,
		strBaseDir:'/etc/xizlr',
		strMainRDMS:'MySQL',
		arrFileStorage:{
			strType:'disk',//can use s3, ftp, sftp, disk
			strLocation:'/var/lib/xilzr',
			bolCacheFiles:true,
			intCacheTime:10, //in seconds
			arrCredentials{
				strUsername:'',
				strPassword:'',
				strPassKey:''
			}
		}
	},
	arrLocalMachine:{
		strMailServer		   = 'localhost',
		strDevReturnDomain = 'localhost'
	}
}
