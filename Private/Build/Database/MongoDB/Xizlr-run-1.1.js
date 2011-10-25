use Xizlr;
db.arrApplicationsConfig.ensureIndex({strApplicationDomainName:1}, {unique: true});
db.arrApplicationsConfig.ensureIndex({strApplicationHandle:1}, {unique: true});
