/**
 * Created by teo on 13.7.2014..
 */
'use strict'


angular.module('AuthentificationModule', ['ngResource'])
    .factory('AuthService', function ($http, Session,$rootScope) {
    var authService = {};

   authService.logout = function () {
        return $http.get('http://etf.ba/api/logout').then(function() {
            document.cookie = "uid=; expires=Thu, 01 Jan 1970 00:00:01 GMT;"
            document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;"
            //Haber.Core.disconnect();
            inicirajPrijavu(0);
            Session.destroy();
        });
   }

    authService.login = function (credentials) {
        return $http({
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            method: 'POST',
            url: 'http://etf.ba/api/login',
            data: {
                'username': credentials.username,
                'password': credentials.password
            },
            transformRequest: function (obj) {
                var str = [];
                for (var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            }
        }).then(function (res) {
            if (res.data.success) {

                document.cookie = "uid="+res.data.user.nick+"; expires=Fri, 31 Dec 9999 23:59:59 GMT;"
                document.cookie = "token="+res.data.user.token+"; expires=Fri, 31 Dec 9999 23:59:59 GMT;"

                Session.create(res.data.user.token, res.data.user.uid, res.data.user.role, res.data.user.nick);
                return res.data;
            }
        });
    };

    authService.remember = function(email) {
        return  $http({
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            method: 'POST',
            url: 'http://etf.ba/api/remember',
            data: {
                'email': email
            },
            transformRequest: function (obj) {
                var str = [];
                for (var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            }
        });
    }

    authService.isAuthenticated = function () {
        return !!Session.userId;
    };

    authService.sessionLost = function() {
        Session.destroy();
    }

    authService.userStatus = function () {
        return $http.get('http://etf.ba/api/status');
    };

    authService.updateUserStatus = function() {

        this.userStatus().then(function (response) {
            // IF user is authentificated on the website but not on the server
            if (!response.data.success && authService.isAuthenticated()) {
                AuthService.sessionLost();
                $rootScope.user.currentUser=null;
                inicirajPrijavu(0);
                $location.path("#/login");
            }

            // IF user is authentificated on the server but not on the website
            if (response.data.success && !authService.isAuthenticated()) {
                $rootScope.user.currentUser = response.data.user;
                var newimg =   "url('http://etf.ba/avatar/"+response.data.user.uid+".jpg')" ;
                Haber.Core.connect(response.data.user.hlogin,response.data.user.token);

            }
            
            // IF user is not authentificated
             if ( !response.data.success && !authService.isAuthenticated()) {
                inicirajPrijavu(0);
             }
        }); 
    }

    return authService;
})
.service('Session', function () {
    this.create = function (sessionId, userId, userRole) {
        this.id = sessionId;
        this.userId = userId;
        this.userRole = userRole;
    };
    this.destroy = function () {
        this.id = null;
        this.userId = null;
        this.userRole = null;
    };
    return this;
});

