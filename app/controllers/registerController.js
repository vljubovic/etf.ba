'use strict';

function registerController($scope, UserService) {

   $scope.user = {};
   $scope.httpStatus = '';
   $scope.errors = [];

   $scope.register = function(isValid) {
       if(isValid) {
           UserService.register($scope.user).success(function(data) {
               if (data.success) {
                    $scope.modalinfo = "Registracija je bila uspjesna provjerite vas fakultetski email";
                    $('#registrationInfo').modal('show');
                    $scope.reset();
                    $location.path("#/main");
               } else 
                   $scope.showErrors(data.error);

           }).error(function(data) {
                $scope.modalinfo = "Registracija nije bila uspjesna konraktirajte Tea";
                $('#registrationInfo').modal('show');
                $scope.reset();
           });
       }
    }


    $scope.showErrors = function(response) {
        $scope.clearErrors();
        $scope.errors.push({path:'', message:response});
    };

    $scope.reset = function() {
        $scope.user = {};
        $scope.clearErrors();
    };

    $scope.clearErrors = function() {
        $scope.httpStatus = '';
        $scope.errors = [];
    };

    $scope.ok = function() {
        $('#registrationInfo').modal('hide');
    }
}