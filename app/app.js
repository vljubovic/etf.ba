'use strict';

var app = angular.module('app', [
    'ngRoute',
    'ngResource',
    'AuthentificationModule',
    'ngSanitize'
])
.config(function($routeProvider, $locationProvider) {
            $routeProvider
             .when('/main', {
                templateUrl: 'app/templates/main.html',
                controller: mainController
            })
            .when('/login', {
                templateUrl: 'app/templates/login.html',
                controller: loginController
            })
            .when('/remember', {
                templateUrl: 'app/templates/remember.html',
                controller: loginController
            })
            .when('/register', {
                templateUrl: 'app/templates/register.html',
                controller: registerController
            });

            $routeProvider.otherwise({redirectTo:'main'});

        });

app.run(function ($rootScope, AuthService) {
    $rootScope.user = {};
    $rootScope.user.currentUser = null;

    $rootScope.$on( "$routeChangeStart", function(event, next, current) {
        if (!current) {
            AuthService.updateUserStatus();
        }     
    });

});

