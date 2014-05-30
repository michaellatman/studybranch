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