/** File: start.js
 * Candy - Chats are not dead yet.
 *
 * Authors:
 *   - Teo Eterovic
 *
 * Copyright:
 *   (c) 2014 ETF.ba. All rights reserved.
 */
var CandyShop = (function(self) { return self; }(CandyShop || {}));

/** Class: CandyShop.Zvjezdice
 * Moderatori
 */
CandyShop.Zvjezdice = (function(self, Candy, $) {
	self.init = function(options) {
		$(Candy).on('candy:view.message.before-render', function(e, args) {
			var room = Candy.Core.getRoom(Candy.View.getCurrent().roomJid);
			if (room != null) {
				var roster = room.getRoster().getAll();

				// iterate and add the nicks to the collection
				$.each(roster, function(index, item) {
					if (item.getNick() == args.templateData.name) {
							if (item.isModerator()) {
								if (item.getRole() === item.ROLE_MODERATOR) {
									args.templateData.displayName = '<span class="moderator '+item.getNick()+'"><span class="star">&nbsp;</span>'+item.getNick()+'</span>';
								}
								if (item.getAffiliation() === item.AFFILIATION_OWNER) {
									args.templateData.displayName = '<span class="owner '+item.getNick()+'"><span class="star">&nbsp;</span>'+item.getNick()+'</span>';
								}
							}
					}
				});
			}
			
			if (args.templateData.displayName[0] == 'ǂ') {
				args.templateData.displayName = '<span class="guest">'+args.templateData.displayName.substring(1)+'</span>';
				args.templateData.message= '<span class="guest">'+args.templateData.message+'</span>';
			}
		});
	}

	return self;
}(CandyShop.Zvjezdice || {}, Candy, jQuery));