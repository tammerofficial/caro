<script>
    (function($) {
        "use strict";
        $('.seller-selector').select2({
            theme: "classic",
            placeholder: '{{ translate('Seller') }}',
            ajax: {
                url: '{{ route('plugin.multivendor.admin.seller.dropdown.list') }}',
                dataType: 'json',
                method: "GET",
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    }
                },
                cache: true
            }
        });
    })(jQuery);
</script>
