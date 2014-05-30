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
App.Organization = DS.Model.extend({
    name: DS.attr('string')
    //users: DS.attr('Array')
});

App.OrganizationSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'organization_id'
});
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


App.User = DS.Model.extend({
    firstName: DS.attr('string'),
    lastName: DS.attr('string'),
    organizations: DS.hasMany('Organization')
});

App.UserSerializer = DS.ActiveModelSerializer.extend({
    primaryKey: 'user_id'
});
App.AssignmentsRoute = Ember.Route.extend({
    model: function() {
        return this.store.find('assignment');

        //return
    }
});
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
	var data = 
	 [
        	{
        		name: "Test",
        		children:[
					{
		        		name: "Level 2",
		        		children:[
							{
				        		name: "Level 3"
				        	},
				        	{
				        		name: "Level 3"
				        	}
		        		]
		        	},
		        	{
		        		name: "Level 2"
		        	}
        		]
        	},
        	{
        		name: "Test"
        	},
        	{
        		name: "Test"
        	}

        ];
    var index = [];
    var filter = function(array, ind){
    	var done = array;
    	for (var i = 0; i<ind.length; i++)
		{
			done = done[ind[i]]['children'];			    
		}	
		return done;
    }
    var get = function(array, ind){
    	var done = array;
    	for (var i = 0; i<ind.length; i++)
		{
			console.log(done);
			if(i==ind.length-1) done = done[ind[i]];
			else done = done[ind[i]]['children'];	

		}	
		return done;
    }
    var level = 0;
    var backLog = [];

App.ClassworkResourceRoute = Ember.Route.extend({

	actions:{
		enter: function(item){
			
			this.controller.get('names').pushObject(
			{
				name: item.name,
				model: this.controller.get('model')
			});
			this.controller.set('model',item.children);
		
			return false; 
		},
		back: function(stack){
			this.controller.set('model',stack.model);
			this.controller.set('names',stack.names);
			return false; 
		}
	},
    model: function() {
    	
        return data;


        //return
    },
    setupController: function(controller,model){
    	this._super(controller,model);
		controller.set('names',Ember.A([]));

    }
});
App.UTCTransform = DS.Transform.extend({
    deserialize: function (data) {
        if (data){

            return moment.utc(data,"YYYY-MM-DD HH:mm:ss");
        }
        return null;
    },

    serialize: function (deserialized) {
        return deserialized;
    }
});
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
App.IndexView = Ember.View.extend({
    didInsertElement : function(){
        this._super();
        Ember.run.schedule('afterRender', this, function(){
            $('.willAnimateIn').each(function(i){
                var t = $(this);
                setTimeout(function(){ t.addClass('animateIn');t.removeClass("willAnimateIn"); }, (i+1) * 10);
            });
        });
        // perform your jQuery logic here
    }
});
//Entire point of this is to set the .active class on navigationbar before route move.

$(".navbar li").click(function(){
    alert("cl");
});