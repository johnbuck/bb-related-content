(function($){

    /**
     * Use this file to register a module helper that
     * adds additional logic to the settings form. The
     * method 'FLBuilder._registerModuleHelper' accepts
     * two parameters, the module slug (same as the folder name)
     * and an object containing the helper methods and properties.
     */
    FLBuilder._registerModuleHelper('bb-related-content-module', {

        /**
         * The 'init' method is called by the builder when
         * the settings form is opened.
         *
         * @method init
         */
        init: function()
        {
            var checkbox = $( '#fl-field-rc-show-border-field input[type="checkbox"]' ),
                colorField = $( '#fl-field-rc-border-color-field'),
                widthField = $( '#fl-field-rc-border-width-field');

            function updateView()
            {
                if ( checkbox.is(':checked') ) {
                    colorField.show();
                    widthField.show();
                } else {
                    colorField.hide();
                    widthField.hide();
                }
            }

            updateView();

            checkbox.click( function() { updateView() } );
        }
    });

})(jQuery);