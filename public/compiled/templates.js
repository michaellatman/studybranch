Ember.TEMPLATES["assignment"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1;


  data.buffer.push("<div class=\"custombox\">\n    <h4>");
  stack1 = helpers._triageMustache.call(depth0, "model.title", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("<span class='pull-right tinsie'>Due 5/27/14</span></h4>\n\n    <p>");
  stack1 = helpers._triageMustache.call(depth0, "model.body", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</p>\n    <button class=\"btn btn-primary\">submit</button>\n</div>");
  return buffer;
  
});

Ember.TEMPLATES["assignments"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n                <li>");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(2, program2, data),contexts:[depth0,depth0],types:["STRING","ID"],data:data},helper ? helper.call(depth0, "assignments.assignment", "item", options) : helperMissing.call(depth0, "link-to", "assignments.assignment", "item", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</li>\n            ");
  return buffer;
  }
function program2(depth0,data) {
  
  var stack1;
  stack1 = helpers._triageMustache.call(depth0, "item.title", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  else { data.buffer.push(''); }
  }

  data.buffer.push("<br>\n<div class='row'>\n    <div id=\"assignment-sidebar\" class=\"col-md-3\">\n        <ul class=\"nav nav-stacked nav-pills\">\n            ");
  stack1 = helpers.each.call(depth0, "item", "in", "model", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        </ul>\n    </div>\n\n    <div class=\"col-md-9\">\n        ");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n        <div>\n            <button data-toggle=\"collapse\" data-target=\"#assignment-sidebar\"\n                    class=\"btn btn-inverse\" >\n                <span class=\"glyphicon glyphicon-fullscreen\"></span>\n            </button>\n            <button class=\"btn btn-inverse pull-right\"><span class='fui-plus'></span></button>\n        </div>\n        <br>\n\n        <div>\n            <div class=\"assignmentbox col-md-9\" id=\"add-assignment\">\n                <form role=\"form\">\n                    <input type=\"text\" class=\"form-control input-transparent\" placeholder=\"Read chapter...\"/>\n\n                    <div class='right'></div>\n                    <br>\n                    <textarea class=\"form-control input-transparent\" rows=\"3\"\n                              placeholder=\"Description...\"></textarea><br>\n\n                </form>\n                <div class=\"row\">\n                    <p><span class=\"glyphicon glyphicon-time\"></span>\n                        <select class=\"input-pad-left input-transparent input-dark\">\n                            <option value=\"volvo\">Today</option>\n                            <option value=\"saab\">Tomorrow</option>\n                            <option value=\"mercedes\">Custom</option>\n                        </select>\n                    </p>\n                </div>\n\n                <br><br>\n                <button class=\"btn btn-inverse\"><span class=\"glyphicon glyphicon-upload\"></span></button>\n                <button class=\"btn btn-inverse pull-right\">Submit</button>\n            </div>\n            <br>\n        </div>\n        <div>\n            <div class=\"assignmentbox col-md-9\" id=\"add-assignment\">\n                <form role=\"form\">\n                    <input type=\"text\" class=\"form-control\" placeholder=\"Assignment Title\"/><br>\n                    <textarea class=\"form-control\" rows=\"3\" placeholder=\"Assignment Body\"></textarea><br>\n\n                    <div class=\"row\">\n                        <div class=\"col-sm-2\">Section</div>\n                        <div class=\"col-sm-8\">\n                            <select class=\"form-control\">\n                                <option>1</option>\n                                <option>2</option>\n                                <option>3</option>\n                                <option>4</option>\n                                <option>5</option>\n                            </select>\n                        </div>\n                        <div class=\"col-sm-2\">\n                            <button class=\"btn btn-inverse\">\n                                <span class=\"fui-plus pull-right\"></span>\n                            </button>\n                        </div>\n                    </div>\n                </form>\n                <form role=\"form\" class=\"form\">\n                    <div class=\"form-group\">\n                        <label class=\"col-sm-2 control-label\" for=\"outDate\">Out Date</label>\n\n                        <div class=\"col-sm-4\"><input type=\"date\" class=\"form-control\" id=\"outDate\"\n                                                     placeholder=\"Out Date\"></div>\n                    </div>\n                    <div class=\"form-group\">\n                        <label class=\"col-sm-2 control-label\" for=\"dueDate\">Duedate</label>\n\n                        <div class=\"col-sm-4\"><input type=\"date\" class=\"form-control\" id=\"dueDate\"\n                                                     placeholder=\"Out Date\"></div>\n                    </div>\n                </form>\n                <br><br>\n                <button class=\"btn btn-inverse\"><span class=\"glyphicon glyphicon-upload\"></span></button>\n                <button class=\"btn btn-inverse pull-right\">Submit</button>\n            </div>\n            <br>\n        </div>\n        <div id=\"assignment-list\" class=\"custombox col-md-9\">\n            <h4>\n                <div class=\"btn-group-vertical pull-right corner-fit\">\n                    <button class=\"btn btn-inverse\" data-toggle=\"tooltip\" data-placement=\"left\"\n                            title=\"Mark as Completed\"><span class=\"fui-check-inverted\"></span></button>\n                    <button class=\"btn btn-inverse\"><span class=\"fui-mail\"></span></button>\n                    <button class=\"btn btn-inverse\"><span class=\"glyphicon glyphicon-pencil\"></span></button>\n                    <button class=\"btn btn-inverse\"><span class=\"glyphicon glyphicon-paperclip\"></span></button>\n                </div>\n                Assignment Title Super long thing to mess with the UI\n            </h4>\n            <span class='tinsie sb-resource'>Due 5/27/14</span>\n\n            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima, debitis, ut, earum quas blanditiis\n                doloremque distinctio autem quae ipsa sint molestias nostrum obcaecati enim vero in. Minima, deserunt,\n                nemo dolores repudiandae possimus eveniet quae laudantium eos exercitationem sed dolor sapiente\n                perferendis suscipit labore voluptatum dignissimos explicabo tempore voluptates ratione cupiditate\n                quisquam enim officiis ea aperiam vitae magni ipsa in ipsam minus neque beatae quod fugit rem quam sit\n                quis vero mollitia fugiat iusto facere repellat accusantium. Vel, delectus quibusdam expedita maxime\n                tempore ipsam sapiente laudantium alias recusandae deserunt eveniet labore inventore adipisci voluptas\n                molestiae repudiandae asperiores iste veritatis aspernatur dolorem?</p>\n\n            <div><p><a class=\"sb-resource\" href=\"#\"><span class=\"glyphicon glyphicon-link\"></span>&nbsp;links go\n                here</a></p>\n\n                <p><a class=\"sb-resource\" href=\"#\"><span class=\"glyphicon glyphicon-link\"></span>&nbsp;resources also go\n                    here</a></p></div>\n            <p>\n                <button class=\"btn btn-primary btn-inverse\">submit</button>\n                <span class=\"\"><a class=\"sb-resource\" href=\"#\">&nbsp;submitted documents appear here</a></span>\n            </p>\n        </div>\n    </div>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["classwork"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1;


  data.buffer.push("<br>\n<div class=\"row classwork-cover\">\n\n    <div class=\"col-xs-12\">\n        <ul class=\"nav nav-pills classwork-centered\">\n            <li class=\"active\"><a href=\"#\">Java</a></li>\n            <li><a href=\"#\">Biology 101</a></li>\n            <li><a href=\"#\">Spanish 3</a></li>\n            <li><a href=\"#\">US History</a></li>\n        </ul>\n        <h2 class=\"lead\">Java</h2>\n\n    </div>\n</div>\n<br>\n");
  stack1 = helpers._triageMustache.call(depth0, "outlet", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n ");
  return buffer;
  
});

Ember.TEMPLATES["classwork/resource"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  


  data.buffer.push("<p>Lol</p>");
  
});

Ember.TEMPLATES["footer"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  


  data.buffer.push("<div class=\"footer\">\n\n</div>");
  
});

Ember.TEMPLATES["index"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, escapeExpression=this.escapeExpression, helperMissing=helpers.helperMissing, self=this;

function program1(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n            <a data-toggle=\"collapse\" ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'data-target': ("#item.id")
  },hashTypes:{'data-target': "STRING"},hashContexts:{'data-target': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(">\n                <div class='custombox willAnimateIn'>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12\">\n                            <h6>");
  stack1 = helpers._triageMustache.call(depth0, "item.title", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("<span\n                                    class='pull-right tinsie'>");
  data.buffer.push(escapeExpression((helper = helpers.fromNow || (depth0 && depth0.fromNow),options={hash:{
    'valueBinding': ("item.updatedAt")
  },hashTypes:{'valueBinding': "STRING"},hashContexts:{'valueBinding': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "fromNow", options))));
  data.buffer.push("</span></h6>\n                        </div>\n                        <!--<button type=\"button\" class=\"btn\" data-toggle=\"collapse\" data-target=\"#demo\">collapse</button>-->\n                    </div>\n                    <div ");
  data.buffer.push(escapeExpression(helpers['bind-attr'].call(depth0, {hash:{
    'id': ("item.id")
  },hashTypes:{'id': "STRING"},hashContexts:{'id': depth0},contexts:[],types:[],data:data})));
  data.buffer.push(" class=\"row collapse in\">\n                        <div class=\"col-xs-12\">\n                            <p>");
  stack1 = helpers._triageMustache.call(depth0, "item.body", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</p>\n                        </div>\n                    </div>\n                    <div class=\"row\">\n                        <div class=\"col-xs-12\"><span class=\"small\">");
  stack1 = helpers._triageMustache.call(depth0, "item.user.name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</span><span\n                                class=\"muted small\">");
  stack1 = helpers._triageMustache.call(depth0, "item.organization.name", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</span></div>\n                    </div>\n                </div>\n            </a>\n        ");
  return buffer;
  }

function program3(depth0,data) {
  
  var buffer = '', stack1, helper, options;
  data.buffer.push("\n            <div class='custombox willAnimateIn'>\n                <h6>");
  stack1 = helpers._triageMustache.call(depth0, "item.title", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push(" <span class='pull-right tinsie'>Due ");
  data.buffer.push(escapeExpression((helper = helpers.fromNow || (depth0 && depth0.fromNow),options={hash:{
    'valueBinding': ("item.dueDate")
  },hashTypes:{'valueBinding': "STRING"},hashContexts:{'valueBinding': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "fromNow", options))));
  data.buffer.push("</span>\n                </h6>\n\n                <p>");
  stack1 = helpers._triageMustache.call(depth0, "item.body", {hash:{},hashTypes:{},hashContexts:{},contexts:[depth0],types:["ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</p>\n            </div>\n        ");
  return buffer;
  }

  data.buffer.push("\n<div class=\"title willAnimateIn\">\n    <h2>Dashboard</h2>\n    <small>last updated ");
  data.buffer.push(escapeExpression((helper = helpers.fromNow || (depth0 && depth0.fromNow),options={hash:{
    'valueBinding': ("loaded")
  },hashTypes:{'valueBinding': "STRING"},hashContexts:{'valueBinding': depth0},contexts:[],types:[],data:data},helper ? helper.call(depth0, options) : helperMissing.call(depth0, "fromNow", options))));
  data.buffer.push("</small>\n</div>\n\n<div class=\"row\">\n    <div class=\"col-md-6 col-xs-12\">\n        <h2 class='lead willAnimateIn'>announcements\n            <button class=\"btn pull-right btn-inverse btn-embossed\"><span class='fui-plus'></span></button>\n        </h2>\n        ");
  stack1 = helpers.each.call(depth0, "item", "in", "model.news", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n\n\n    </div>\n    <div class=\"col-md-6 col-xs-12\">\n\n        <h2 class='lead willAnimateIn'>assignments\n            <button class=\"btn pull-right btn-inverse btn-embossed\"><span class='fui-plus'></span></button>\n        </h2>\n        ");
  stack1 = helpers.each.call(depth0, "item", "in", "model.assignments", {hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0,depth0,depth0],types:["ID","ID","ID"],data:data});
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("\n    </div>\n</div>\n");
  return buffer;
  
});

Ember.TEMPLATES["navbar"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  var buffer = '', stack1, helper, options, self=this, helperMissing=helpers.helperMissing;

function program1(depth0,data) {
  
  
  data.buffer.push("Home");
  }

function program3(depth0,data) {
  
  
  data.buffer.push("News");
  }

function program5(depth0,data) {
  
  
  data.buffer.push("Assignments");
  }

function program7(depth0,data) {
  
  
  data.buffer.push("Classwork");
  }

  data.buffer.push("<div class=\"navbar navbar-inverse navbar-fixed-top willAnimateIn\" role=\"navigation\">\n    <div class=\"container-fluid\">\n        <div class=\"navbar-header\">\n            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">\n                <span class=\"sr-only\">Toggle navigation</span>\n                <span class=\"icon-bar\"></span>\n                <span class=\"icon-bar\"></span>\n                <span class=\"icon-bar\"></span>\n            </button>\n            <a class=\"navbar-brand\" href=\"#\">StudyBranch</a>\n\n        </div>\n        <div class=\"collapse navbar-collapse\">\n            <ul class=\"nav navbar-nav\">\n                <li>");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(1, program1, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "index", options) : helperMissing.call(depth0, "link-to", "index", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</li>\n                <li>");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(3, program3, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "news", options) : helperMissing.call(depth0, "link-to", "news", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</li>\n                <li>");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(5, program5, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "assignments", options) : helperMissing.call(depth0, "link-to", "assignments", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</li>\n                <li>");
  stack1 = (helper = helpers['link-to'] || (depth0 && depth0['link-to']),options={hash:{},hashTypes:{},hashContexts:{},inverse:self.noop,fn:self.program(7, program7, data),contexts:[depth0],types:["STRING"],data:data},helper ? helper.call(depth0, "classwork", options) : helperMissing.call(depth0, "link-to", "classwork", options));
  if(stack1 || stack1 === 0) { data.buffer.push(stack1); }
  data.buffer.push("</li>\n            </ul>\n        </div>\n        <!--/.nav-collapse -->\n    </div>\n</div>\n\n");
  return buffer;
  
});

Ember.TEMPLATES["news"] = Ember.Handlebars.template(function anonymous(Handlebars,depth0,helpers,partials,data) {
this.compilerInfo = [4,'>= 1.0.0'];
helpers = this.merge(helpers, Ember.Handlebars.helpers); data = data || {};
  


  data.buffer.push("<div class=\"row\">\n    <div class=\"col-xs-12\">\n        <p>Welcome to the news page!</p>\n    </div>\n</div>");
  
});