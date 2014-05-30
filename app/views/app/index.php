<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>StudyBranch</title>
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="/libs/flat-ui/css/flat-ui.css">
    <link rel="stylesheet"  type="text/css" href="/css/theme.css">

    <meta name="viewport" content="width=device-width, user-scalable=no">
</head>
<body>
<script type="text/x-handlebars">
    {{render "navbar"}}
    <div class="container main">
      {{outlet}}
    </div>
    {{render "footer"}}
</script>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://fgnass.github.io/spin.js/spin.min.js"></script>
<script src="http://fgnass.github.io/spin.js/jquery.spin.js"></script>
<script src="/bower_components/momentjs/min/moment.min.js"></script>
<script src="/libs/flat-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="/libs/flat-ui/js/jquery.ui.touch-punch.min.js"></script>
<script src="/libs/flat-ui/js/bootstrap-select.js"></script>
<script src="/libs/flat-ui/js/bootstrap-switch.js"></script>
<script src="/bower_components/handlebars/handlebars.min.js"></script>
<script src="/bower_components/ember/ember.js"></script>
<script src="/bower_components/ember-data/ember-data.js"></script>
<script src="/compiled/templates.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="/bower_components/less.js/dist/less-1.7.0.min.js"></script>
<script src="/libs/flat-ui/js/flatui-checkbox.js"></script>
<script src="/libs/flat-ui/js/flatui-radio.js"></script>
<script src="/libs/flat-ui/js/html5shiv.js"></script>
<script src="/libs/flat-ui/js/icon-font-ie7.js"></script>
<script src="/libs/flat-ui/js/jquery.placeholder.js"></script>
<script src="/libs/flat-ui/js/jquery.tagsinput.js"></script>
<script src="/libs/flat-ui/js/respond.min.js"></script>
<script src="/libs/flat-ui/js/typeahead.js"></script>
<script src="/libs/flat-ui/js/application.js"></script>
<script src="/compiled/app.js"></script>
<script src="//localhost:35729/livereload.js"></script>

<script>

    //less.watch();</script>
</body>
</html>