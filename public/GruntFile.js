module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            development: {
                options: {
                    paths: ["assets/css"]
                },

                files: {
                    "css/theme.css":
                    "less/*.less"
                }
            }
        },
        emberTemplates: {
            compile: {
                options: {
                    templateBasePath: /js\/templates\//
                },
                files: {
                    "compiled/templates.js": ["js/templates/**/*.hbs","js/templates/*.hbs"]
                }
            }
        },
        concat: {
            options: {
            },
            dist: {
                src: 'js/**/*.js',
                dest: 'compiled/app.js'
            }
        },
        watch: {
            ember:{
                files: ["js/templates/**/*.hbs","js/templates/*.hbs"],
                tasks: ['emberTemplates'],
                options: {
                    livereload: true
                }
            },
            less: {
                files: "less/*.less",
                tasks: ['less'],
                options: {
                    livereload: true
                }
            },
            js: {
                files: "js/**/*.js",
                tasks: ['concat'],
                options: {
                    livereload: true
                }
            }
        }
    })

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-ember-templates');
    grunt.registerTask('default', ['less','emberTemplates','watch']);
    grunt.loadNpmTasks('grunt-contrib-concat');
};