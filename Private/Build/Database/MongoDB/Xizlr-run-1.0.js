use dbXizlr;
db.createCollection("arrApplicationsConfig");
db.arrApplicationsConfig.ensureIndex({strApplicationDomainName:1}, {unique: true});
db.arrApplicationsConfig.ensureIndex({strApplicationHandle:1}, {unique: true});
db.createCollection("arrComponentsConfig");
db.arrComponentsConfig.ensureIndex({strComponentHandle:1, strComponentId:1}, {unique: true});
db.arrComponentsConfig.save({
	"strComponentHandle":"Page",
	"strComponentId"    : "Index",
	"strPageTitle":"Welcome To Xizlr!",
	"strPageDecription": "This is the Xizlr default page. If you can see this then Xizlr is correctly installed.",
	"strContents":"<h1>Xizlr</h1><p>Welcome to Xizlr!</p>"
});

