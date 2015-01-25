'use strict';

app.directive('headerDirective', function (AuthService, $rootScope, $timeout,$http) {
        return {   
			restrict: 'AE',
			templateUrl: 'app/directives/headerDirective/headerDirective.tpl.html', 
            link: function (scope, elm, attr, ctrl) {
        				scope.header ={};
        				scope.header.backgroundUrl='default';
          				
        				scope.updateAvatar = function() {
        					if (!angular.element('.menu-avatar').css( "background-image") && !$rootScope.user.currentUser) {
        						$timeout(function() {
        							scope.updateAvatar();
        						});
        					} else {
        						$timeout(function() {
        							angular.element('.menu-avatar').css( "background-image", "url('http://etf.ba/avatar/"+$rootScope.user.currentUser.uid+".jpg')")
        						});
        					}
        				}

        				scope.updateAvatar();
                    	   
                scope.logout = function() {
                    AuthService.logout().then(function() { 
                    $rootScope.user.currentUser = null;
        						window.location.href="#/main";
                  });
        				}
                
            }
        };
    }
);   