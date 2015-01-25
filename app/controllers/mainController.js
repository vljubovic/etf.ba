'use strict';

function mainController($scope, SocialService) {

		$scope.posts = {};
		$scope.comments= {};
		$scope.comments.data= {};
		
	  	SocialService.getAllPosts().then(function (response) {
            $scope.posts=response.data;
         });

         $scope.closeComments = function() {
         	$('#commentModal').modal('hide');
         }
}