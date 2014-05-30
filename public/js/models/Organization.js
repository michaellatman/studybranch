App.Organization = DS.Model.extend({
    name: DS.attr('string')
    //users: DS.attr('Array')
});

App.OrganizationSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'organization_id'
});