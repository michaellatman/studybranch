

App.Assignment = DS.Model.extend({
    title: DS.attr('string'),
    body: DS.attr('string'),
    updatedAt: DS.attr('UTC'),
    createdAt: DS.attr('UTC'),
    section: DS.belongsTo('section', {embedded: 'always'}),
    dueDate: DS.attr("UTC")
});

App.AssignmentSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'assignment_id',
    keyForRelationship: function(rel, kind) {
        if (kind === 'belongsTo') {
            return "section_id";
        }
    }
});