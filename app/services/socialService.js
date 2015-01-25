'use strict'

app.service('SocialService', function($http) {
    this.data={}; 

 
    this.getAllPosts= function () {
		return $http.get('api/wall');
	}

	this.createPost = function(message) {
		return $http({
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					method: 'POST',
					url: 'api/post',
					data: { 'post': message },
					transformRequest: function (obj) {
						var str = [];
						for (var p in obj)
							str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
						return str.join("&");
					}
				});
	}

});