'use strict';

function loginController($scope, AuthService,$rootScope) {
    
    $scope.credentials = {
        username: '',
        password: ''
    };

    $scope.login = function (credentials) {
        AuthService.login(credentials).then(function (data) {
            if (data && data.success ) {
                var user = data.user;
                $rootScope.user.currentUser= user;
                Haber.Core.connect(user.hlogin,user.token);
                angular.element('.menu-avatar').css( "background-image", "url('http://etf.ba/avatar/"+user.uid+".jpg')" );
                
                window.location.href = '#/main';
            } else {
                alert("Login podaci nisu ispravni");
            }

        }, function () {
            alert("Login nije uspio kontaktirajte Tea");
        });
    };

    $scope.remember = function(credentials) {
        AuthService.remember(credentials.email).then(function (data) {
            if (data.data && data.data.success) {
               alert('Provjerite vas fakultetski email verifikacijski kod je poslan');
                window.location.href = '#/main';
            } else {
                alert("Pogresan fakultetski email ili mail nije mogao biti poslan");
            }

        }, function () {
            alert("Remember me nije uspio kontaktirajte Tea");
        });
    }
}