'use strict';

app.directive('socialDirective', function (SocialService,$http) {
    return {
			restrict: 'AE',
			templateUrl: 'app/directives/socialDirective/socialDirective.tpl.html', 
            link: function (scope, elm, attr, ctrl) {
            	scope.view ={};
            	scope.view.showDobars= false;
            	scope.view.dobars= {};

              //TODO: Refactor http requestovi trebaju ici u servis

          		scope.showDobar = function(postRef) {
      					$http.get('api/getdobar/'+postRef.fk_resource).then(function(response) {
      						if (response.data.length!=0) {
      							scope.view.dobars = response.data;
      							scope.view.showDobars=true;
      						} 
					      });  
          		} 

          		scope.showComments = function(post) {
          			$http.get('api/comments/'+post.fk_resource).success(function(response){
          				if (response){
          					scope.comments.data= {};
          					scope.comments.data= response;
          				}
          			});
					      $('#commentModal').modal('show');
          		}

          		scope.doDobar = function(postRef, event) {
          			$http.get('api/dobar/'+postRef.fk_resource).then(function(response) {
          				if (response.data.success) {
          					scope.post.dobar++;
							      angular.element(event.target).css('color' , '#16A085');
          				} else {
          					angular.element(event.target).removeClass('fui-check').addClass('fui-cross');
          				}
          			});
          		}
            }
        };
    }
);