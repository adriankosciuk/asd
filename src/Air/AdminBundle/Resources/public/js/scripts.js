(function($){
    
    $(document).ready(function(){
        
        //confirm action snippet
        $('[data-confirmAction]').click(function(){
            var $this = $(this);
            var message = $this.attr('data-confirmAction') || 'Czy na pewno chcesz wykonac ta akcje?';

            return confirm(message);
        });


        //select2 plugin initalize
        $('select').select2({
            allowClear: true
        });


        //initalize popups
        $('[data-original-title]').tooltip();

        //filter&search form handling
        var $filterSearchForm = $('form.filter-search');
        $filterSearchForm.find('[name="limit"]').change(function(){
                $filterSearchForm.submit();
        });
        
        
        //submit form after change limit select
        $('form [name="limit"]').change(function(){
            $(this).closest('form').submit();
        });
                
                
    });
    
})(jQuery);