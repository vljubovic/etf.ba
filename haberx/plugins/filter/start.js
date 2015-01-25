/*
 * FilterPost
 * @version 1.0
 * @author Teo Eterovic
 *
 * Filters posts
 */

var CandyShop = (function(self) { return self; }(CandyShop || {}));

CandyShop.FilterPost = (function(self, Candy, $) {


	/** Function: init
	 * Initializes the inline-images plugin with the default settings.
	 */
	self.init = function() {
		$(Candy).on('candy:view.message.before-show', handleBeforeShow);
		$(Candy).on('candy:view.message.after-show', handleOnShow);
	};

	/** Function: initWithFileExtensions
	 * Initializes the inline-images plugin with the possibility to pass an
	 * array with all the file extensions you want to display as image.
	 *
	 * Parameters:
	 *   (String array) fileExtensions - Array with extensions (jpg, png, ...)
	 */
	self.initWithFileExtensions = function(fileExtensions) {
		_fileExtensions = fileExtensions;
		self.init();
	};

	/** Function: initWithMaxImageSize
	 * Initializes the inline-images plugin with the possibility to pass the
	 * maximum image size for displayed images.
	 *
	 * Parameters:
	 *   (int) maxImageSize - Maximum edge size for images
	 */
	self.initWithMaxImageSize = function(maxImageSize) {
		_maxImageSize = maxImageSize;
		self.init();
	};

	/** Function: initWithFileExtensionsAndMaxImageSize
	 * Initializes the inline-images plugin with the possibility to pass an
	 * array with all the file extensions you want to display as image and
	 * the maximum image size for displayed images.
	 *
	 * Parameters:
	 *   (String array) fileExtensions - Array with extensions (jpg, png, ...)
	 *   (int) maxImageSize - Maximum edge size for images
	 */
	self.initWithFileExtensionsAndMaxImageSize = function(fileExtensions, maxImageSize) {
		_fileExtensions = fileExtensions;
		_maxImageSize = maxImageSize;
		self.init();
	};


	/** Function: handleBeforeShow
	 * Handles the beforeShow event of a message.
	 *
	 * Paramteres:
	 *   (Object) args - {roomJid, element, nick, message}
	 *
	 * Returns:
	 *   (String)
	 */
	var handleBeforeShow = function(e, args) {
		var message = args.message;
		var time = e.timestamp;
		var nick = e.nick;
	};


	/** Function: handleOnShow
	 * Each time a message gets displayed, this method checks for possible
	 * image loaders (created by buildImageLoaderSource).
	 * If there is one, the image "behind" the loader gets loaded in the
	 * background. As soon as the image is loaded, the image loader gets
	 * replaced by proper scaled image.
	 *
	 * Parameters:
	 *   (Array) args
	 */
	var handleOnShow = function(e, args) {
		
	};



	return self;
}(CandyShop.FilterPost || {}, Candy, jQuery));
