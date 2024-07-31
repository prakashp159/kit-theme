( function( $ ) {
    var ajaxurl  = wpRiders.ajaxurl;
    var homeurl  = wpRiders.homeurl;
    var themeurl = wpRiders.themeurl;
    var isPhoneAppFilter = wpRiders.isPhoneAppFilter;
    $( '#operatingSystemsFilters ul li a' ).on( 'click', function(e) {
        if ( !isPhoneAppFilter ) {
            return;
        }
        e.preventDefault();
        if ( $( this ).attr( 'data-prevent-filter' ) == '1' ) {
            return;
        }
        $( '#operatingSystemsFilters ul li' ).removeClass( 'current-menu-item' );
        $( this ).parent().addClass( 'current-menu-item' ); //Process current menu item
        $( '#operatingSystemsFilters ul li a').attr( 'data-prevent-filter', '1' ); //Prevent multipe ajax calls
        $( '.home-phone-apps-list' ).html( '<div class="fa-3x text-center"><i class="fas fa-spinner fa-pulse"></i></div>' ); //Add loader html

        var previosHtmlContent = $( '.home-phone-apps-list' ).html();
        var dataSlug = $( this ).attr( 'data-slug' );
        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'phone_apps_filter',
                home_url: homeurl ,
                operating_system : dataSlug
            },
            success: function( response ) {
                $( '#operatingSystemsFilters ul li a' ).removeAttr( 'data-prevent-filter' );
                $( '.home-phone-apps-list' ).html( response );
            },
            error: function( xhr ) {
                $( '#operatingSystemsFilters ul li a' ).removeAttr( 'data-prevent-filter' );
                $( '.home-phone-apps-list' ).html( previosHtmlContent );
                alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
            }
        });
    } );
} ( jQuery ) );