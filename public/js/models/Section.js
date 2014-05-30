App.Section = DS.Model.extend({
    name: DS.attr('string'),
    updatedAt: DS.attr('date')
});

App.SectionSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'section_id',
    keyForRelationship: function(rel, kind) {
        if (kind === 'belongsTo') {
            return "section_id";
        }
    }
});

