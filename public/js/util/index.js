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