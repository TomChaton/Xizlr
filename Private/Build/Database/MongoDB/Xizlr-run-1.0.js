use dbXizlr;
db.createCollection("arrApplicationsConfig");
db.arrApplicationsConfig.ensureIndex({strApplicationDomainName:1}, {unique: true});
db.arrApplicationsConfig.ensureIndex({strApplicationHandle:1}, {unique: true});
db.createCollection("arrComponentsConfig");
db.arrApplicationsConfig.ensureIndex({strComponentHandle:1, strComponentId:1}, {unique: true});
