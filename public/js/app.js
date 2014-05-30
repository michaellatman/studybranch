App = Ember.Application.create();

App.Router.map(function() {
    this.resource('about');
    this.resource('assignments', function() {
        this.route('assignment', { path: ':assignment_id' });
    });
     this.resource('classwork', function() {
        this.route('resource', { path: '/:resourceID' });
    }); 
    this.resource('news');
});

App.ApplicationAdapter = DS.ActiveModelAdapter.extend({
    namespace: 'api/1'
});

App.ApplicationView = Ember.View.extend({
    didInsertElement : function(){
        this._super();
        Ember.run.schedule('afterRender', this, function(){
            $('.navbar ul a').click(function() {
                var navbar_toggle = $('.navbar-toggle');
                if (navbar_toggle.is(':visible')) {
                    navbar_toggle.trigger('click');
                }
            });
            $('.willAnimateIn').each(function(i){
                var t = $(this);
                setTimeout(function(){ t.addClass('animateIn');t.removeClass("willAnimateIn"); }, (i+1) * 10);
            });
        });
        // perform your jQuery logic here
    }
});



