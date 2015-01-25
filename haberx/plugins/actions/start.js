var CandyShop = (function(self) { return self; }(CandyShop || {}));

CandyShop.Actions = (function(self, Candy, $) {

    self.init = function() {
        Candy.View.Event.Message.beforeShow = function(args) {
            var message = ($.type(args) !== 'string') ? /* Candy >= 1.0.4 */ args.message : /* Candy < 1.0.4 */ args;
            return message.replace(/^\/me (.*)/, '<span class="action">$1</span>');
        };
    };

    return self;
}(CandyShop.Actions || {}, Candy, jQuery));