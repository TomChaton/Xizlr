use Xizlr;
db.createCollection("arrApplications");
db.arrApplications.ensureIndex({strApplicationDomainName:1}, {unique: true});
