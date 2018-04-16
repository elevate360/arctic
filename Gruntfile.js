/* jshint node:true */
module.exports = function (grunt) {

	'use strict';

	// Project configuration.
	grunt.initConfig({

		pkg: grunt.file.readJSON( 'package.json' ),

		// Check textdomain errors.
		checktextdomain: {
			options:{
				text_domain: '<%= pkg.name %>',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php', // Include all files
					'!node_modules/**',
					'!dist/**',
					'!orig/**'
				],
				expand: true
			}
		},

		makepot: {
			options: {
				type: 'wp-theme',
				domainPath: 'languages',
				potHeaders: {
					'report-msgid-bugs-to': 'https://campaignkit.co/contact',
					'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
				}
			},
			frontend: {
				options: {
					potFilename: '<%= pkg.name %>.pot',
					exclude: [
						'node_modules/.*',
						'dist/.*',
						'orig/.*'
					]
				}
			}
		},

		// Compile all .scss files.
		sass: {
			dist: {
				options: {
					sourceMap: false
				},
				files: [{
					'style.css' : 'sass/style.scss',
					'assets/css/editor-style.css' : 'sass/editor-style.scss',
					'assets/css/customizer-control.css' : 'sass/customizer-control.scss'
				}]
			}
		},

		cmq: {
			options: {
				compress: false,
				logFile: false
			},
			media: {
				files: [{
					'style.css' : 'style.css',
					'assets/css/editor-style.css' : 'assets/css/editor-style.css',
					'assets/css/customizer-control.css' : 'assets/css/customizer-control.css'
				}]
			}
		},

		// Autoprefixer.
		postcss: {
			options: {
				processors: [
					require( 'autoprefixer' )({
						browsers: [
							'> 0.1%',
							'ie 8',
							'ie 9'
						]
					})
				]
			},
			dist: {
				src: [
					'style.css',
					'!style.min.css',
					'assets/css/*.css',
					'!assets/css/*.css'
				]
			}
		},

	    wpcss: {
	        style: {
	            options: {
	                commentSpacing: true
	            },
				files: [{
					'style.css' : 'style.css',
					'assets/css/editor-style.css' : 'assets/css/editor-style.css',
					'assets/css/customizer-control.css' : 'assets/css/customizer-control.css'
				}]
	        }
	    },

		// RTLCSS
		rtlcss: {
			main: {
				options: {},
				expand: true,
				ext: '-rtl.css',
				src: [
					'style.css',
					'assets/css/editor-style.css',
					'assets/css/customizer-control.css'
				]
			}
		},

		cssmin: {
			target: {
				files: [{
					expand: true,
					cwd: './',
					src: [
						'./*.css',
						'!./*.min.css',
						'assets/css/*.css',
						'!assets/css/*.min.css'],
					dest: './',
					ext: '.min.css'
				}]
			}
		},

		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/*.js',
				'!assets/js/*.min.js'
			]
		},

		concat: {
			frontend: {
				src: ['assets/js/frontend/*.js'],
				dest: 'assets/js/frontend.js'
			}
		},

		jsbeautifier: {
		    files : [
		    	'assets/js/*.js',
		    	'!assets/js/*.min.js'
		    ],
		    options : {
		    }
		},

		uglify: {
			options: {
				preserveComments: 'some'
			},
			js: {
				files: [{
					expand: true,
					cwd: 'assets/js/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/',
					ext: '.min.js'
				}]
			}
		},

		watch: {
			css: {
				files: [
					'sass/*.scss',
					'sass/*/*.scss',
					'sass/*/*/*.scss',
					'sass/*/*/*/*.scss'
				],
				tasks: [
					'sass',
					'cssmin'
				]
			},
			frontend: {
				files: [
					'assets/js/frontend/*.js'
				],
				tasks: [
					'concat',
					'uglify'
				]
			},
			js: {
				files: [
					'assets/js/customizer.js',
					'assets/js/customizer-control.js'
				],
				tasks: [
					'uglify'
				]
			}
		},

		// Replace text
		replace: {
			themeVersion: {
				src: [
					'sass/style.scss'
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				} ]
			},
			readme: {
				src: [
					'readme.txt'
				],
				overwrite: true,
				replacements: [ {
					from: /^.*Stable tag:.*$/m,
					to: 'Stable tag: <%= pkg.version %>'
				} ]
			}
		},

		wp_readme_to_markdown: {
			your_target: {
				files: {
					'README.md': 'readme.txt'
				}
			}
		},

		// Clean up dist directory
		clean: {
			main: ['dist']
		},

		// Copy the theme into the dist directory
		copy: {
			main: {
				src:  [
					'**',
					'!csscomb.json',
					'!node_modules/**',
					'!.sass-cache/**',
					'!sass/**',
					'!dist/**',
					'!orig/**',
					'!.git/**',
					'!vendor/**',
					'!Gruntfile.js',
					'!composer.json',
					'!composer.lock',
					'!package.json',
					'!package-lock.json',
					'!phpcs.xml.dist',
					'!.gitignore',
					'!.gitmodules',
					'!**/Gruntfile.js',
					'!**/package.json',
					'!**/*~'
				],
				dest: 'dist/<%= pkg.name %>/'
			}
		},

		// Compress build directory into <name>.<version>.zip
		compress: {
			main: {
				options: {
					mode: 'zip',
					archive: './dist/<%= pkg.name %>.<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'dist/<%= pkg.name %>/',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		}

	});

    grunt.loadNpmTasks( 'grunt-checktextdomain' );
    grunt.loadNpmTasks( 'grunt-combine-media-queries' );
    grunt.loadNpmTasks( 'grunt-contrib-clean' );
    grunt.loadNpmTasks( 'grunt-contrib-compress' );
    grunt.loadNpmTasks( 'grunt-contrib-concat' );
    grunt.loadNpmTasks( 'grunt-contrib-copy' );
    grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
    grunt.loadNpmTasks( 'grunt-contrib-jshint' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-jsbeautifier' );
    grunt.loadNpmTasks( 'grunt-postcss' );
    grunt.loadNpmTasks( 'grunt-rtlcss' );
    grunt.loadNpmTasks( 'grunt-sass' );
    grunt.loadNpmTasks( 'grunt-text-replace' );
    grunt.loadNpmTasks( 'grunt-wp-css' );
    grunt.loadNpmTasks( 'grunt-wp-i18n' );
    grunt.loadNpmTasks( 'grunt-wp-readme-to-markdown' );

	grunt.registerTask( 'css', [
		'sass',
		'cmq',
		'postcss',
		'wpcss',
		'rtlcss',
		'cssmin'
	]);

	grunt.registerTask( 'js', [
		'concat',
		'jsbeautifier',
		'jshint',
		'uglify'
	]);

	grunt.registerTask( 'prepare', [
		'checktextdomain',
		'js',
		'replace',
		'css',
		'wp_readme_to_markdown',
		'makepot'
	]);

	grunt.registerTask( 'dist', [
		'prepare',
		'clean',
		'copy',
		'compress'
	]);

};
