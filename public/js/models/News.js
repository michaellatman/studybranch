App.News = DS.Model.extend({
    title: DS.attr('string'),
    body: DS.attr('string'),
    updatedAt: DS.attr('UTC'),
    createdAt: DS.attr('UTC'),
    organization: DS.belongsTo('organization', {embedded: 'always'})
});

App.NewsSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'announcement_id',
    keyForRelationship: function(rel, kind) {
        if (kind === 'belongsTo') {
            return "organization";
        }
    }
});