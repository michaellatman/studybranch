App.IndexController = Ember.Controller.extend({
    actions:{

    }
});


App.IndexRoute = Ember.Route.extend({
    model: function() {
        if(this.get('loaded') == true){
            console.log('cached');
            return Ember.RSVP.hash({
                "news":this.store.all('news'),
                "assignments":this.store.all('assignment')
            })
        }
        else   console.log('not cached');
        this.set('loaded',true);
        return Ember.RSVP.hash({
            "news":this.store.find('news'),
            "assignments":this.store.find('assignment')
        })


        //return
    },
    actions: {
        loading: function(transition, originRoute) {
            // displayLoadingSpinner();

            // Return true to bubble this event to `FooRoute`
            // or `ApplicationRoute`.
            $("body").spin(true);
            this.router.one('didTransition', function() {
                $("body").spin(false);


            });
            return true;
        }
    },
    setupController: function(controller,model){
        this._super(controller, model);
        controller.set('loaded',new Date());
    }
});