App.AssignmentsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('assignment');

        //return
    }
});