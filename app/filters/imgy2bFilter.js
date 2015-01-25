app.filter('imgy2bFilter', function ($filter) {
        return function (value) {
            if (!value) return '';

			var imageMatch = /(https?:\/\/\S+(\.png|\.jpg|\.gif))/g;
			var y2bMatch = /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;
			
			var isfiltered = 0;			
			if (value.search(imageMatch) >= 0) {
				value=value.replace(imageMatch, '<a href="$1" target="_blank"><img width="100%" src="$1" /></a>');
				isfiltered = 1;
			}

			if (value.search(y2bMatch) >= 0) { 
				
				value= value.replace(y2bMatch, '<div class="y2bleft"><a href="https://www.youtube.com/watch?v=$1" target="_blank"><img width="100%" src="http://img.youtube.com/vi/$1/1.jpg"></a></div><div class="y2bright"><a href="https://www.youtube.com/watch?v=$1" target="_blank"><img  src="http://etf.ba/images/youtube.png">&nbsp;&nbsp;<b> Youtube video</b></a></div>');
				isfiltered = 1;
			}
            
            if (!isfiltered)
            	value = $filter('linky')(value,'_blank');

            return value;
        };
    });