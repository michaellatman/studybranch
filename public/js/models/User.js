App.User = DS.Model.extend({
    firstName: DS.attr('string'),
    lastName: DS.attr('string'),
    organizations: DS.hasMany('Organization')
});

App.UserSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'user_id'
});