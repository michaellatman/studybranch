App.FromNowView = Ember.View.extend({
    tagName: 'time',

    template: Ember.Handlebars.compile('{{view.output}}'),

    didInsertElement: function() {
        this.tick();
    },
    tick: function() {
        //this.send('tick');
        //this.get("controller").send("refresh");
        var nextTick = Ember.run.later(this, function() {
            this.notifyPropertyChange('value');
            // Re-render the view somehow
            this.tick();
        }, 1000);
        this.set('nextTick', nextTick);
    },
    output: function() {
        return moment(this.get('value')).fromNow();
    }.property('value'),
    willDestroyElement: function() {
        var nextTick = this.get('nextTick');
        Ember.run.cancel(nextTick);
    }
});
Ember.Handlebars.helper('fromNow', App.FromNowView);