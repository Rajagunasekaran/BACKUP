module.exports = function(grunt) {
    grunt.initConfig({
        uglify: {
            js: {
                files: {
                    'scripts/main.min.js': ['scripts/main.js']
                },
                options: {
                    compress:true
                }
            }
        },
        sass: {
			dist: {
				options: {
					style: 'compressed',
				},
				files: {
					'css/main.min.css': 'css/main.scss',
				},
                loadPaths:['css/core']
			}
		},
        watch:{
            scripts: {
                files: [
                    'css/*.scss',
                    'css/*/*.scss',
                    'scripts/main.js',
                    'index.html',
                ],
                tasks: ['uglify','sass'],
                options: {
                    livereload:true
                }
            }
        }
    });
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default',['uglify','sass','watch']);
};