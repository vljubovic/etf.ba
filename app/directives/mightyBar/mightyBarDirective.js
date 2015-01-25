'use strict';

app.directive('mightyBar', function (SocialService,$http, $compile, $rootScope) {
        return {
			restrict: 'AE',
			templateUrl: 'app/directives/mightyBar/mightyBarDirective.tpl.html', 
            link: function (scope, elm, attr, ctrl) {
            	scope.bar= {};
            	scope.bar.show=false;

            	// Create a new post on the wall
            	scope.post = function() {
            		SocialService.createPost(scope.bar.tekst).success(function(resp) {
						if (resp.success) {
							var user= $rootScope.user.currentUser;

							var newPost = {'fk_resource': resp.rid, 
											'message' : scope.bar.tekst, 
											'firstname': user.nick, 
											'replies' : 0, 
											'dobar':0, 
											'administartor':user.status, 
											'sh_box_moderator':0, 
											'uid':user.uid };

							scope.posts.unshift(newPost);
							scope.bar.tekst = "";
							scope.bar.show=false;
						} else {
							alert(resp.error);
						}
					}).error(function(data) {
						alert('Doslo je do greske');	
					});
            	}
            }
        };
    }
);            