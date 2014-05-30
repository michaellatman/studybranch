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