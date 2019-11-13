jQuery(document).ready(function($){
    function handleFirstTab(e) {
        if (e.keyCode === 9) { // the "I am a keyboard user" key
            document.body.classList.add('user-is-tabbing');
            window.removeEventListener('keydown', handleFirstTab);
        }
    }
    
    window.addEventListener('keydown', handleFirstTab);

    $('.main_menu .menu_icon').attr('aria-hidden', 'true')
    $('.qode_icon_font_awesome').attr('aria-hidden', 'true')
    $('footer .fa-linkedin').closest('.fa-stack').after('<span class="sr-only">LinkedIn</span>')

    function toggleAriaExpanded(target){
        if(target.attr('aria-expanded') === 'true'){
            target.attr('aria-expanded', 'false');
        } else {
            target.attr('aria-expanded', 'true');
        }
    }

    var $links = $('.menu-item-has-children > a'); //Top level hyperlinks w/ dropdowns
    var $dropdowns = $('.menu-item-has-children'); //Top level nav items w/ dropdowns
    var $dropdownMenus = $('.second'); //Dropdowns
    var $menuItems = $('#menu-top_menu > .menu-item > a'); //Top level hyperlinks

    //Hide all other dropdowns when focusing on top level menu items
    $menuItems.each(function(){
        var $dropdown = $(this).find('.second');
        $(this).on('focus', function(){
            console.log('Focus: ' + $dropdown);
            //Hide all other dropdowns
            $dropdownMenus.not($dropdown).removeClass('drop_down_start').css('height', 0);
            $(this).attr('aria-expanded', 'true');
            $links.not($(this)).attr('aria-expanded', 'false');
            $(document).off('keydown.enter-dropdown');
            $(document).off('keydown.in-dropdown');
            //$dropdown.css('height', '');
        });
    });


    $dropdowns.each(function(){
        var $this = $(this);
        var $link = $(this).find('> a');
        var $dropdown = $(this).find('.second');
    
        //Decorate menu w/ Aria
        $link.attr('data-toggle', 'dropdown');
        $link.attr('aria-haspopup', 'true');
        $link.attr('aria-expanded', 'false');

        var id = ($(this).attr('id') + '-toggle');
        $link.attr('id', id);
        $dropdown.attr('aria-labelledby', id);

        //Toggle Aria on hover
        $(this).on('mouseenter', function(){
            $links.attr('aria-expanded', 'false');
            $link.attr('aria-expanded', 'true');
        })
        
        $(this).on('mouseleave', function(){
            $links.attr('aria-expanded', 'false');
        })


        //When leaving top level item, if not focusing related dropdown, hide
        $link.on('blur', function(e){
            $parent = $(this).closest('.menu-item');
            if($parent.has(e.relatedTarget).length === 0){
                toggleAriaExpanded($(this));
                $dropdown.removeClass('drop_down_start').css('height', 0);
                // $(document).off('keydown.enter-dropdown');
                // $(document).off('keydown.in-dropdown');
            }
               
        })

        $link.on('focus', function(e){
            $(document).off('keydown.enter-dropdown');
            $(document).off('keydown.in-dropdown');

            console.log('Focus menu w/ dropdown')
            
            var id = $(this).closest('li').attr('id');
            
           // $(window).trigger('resize');

            window.setTimeout(function(){
                console.log('open!')
                $dropdown.addClass('drop_down_start');
                $this.trigger('click')
            }, 100);

        //     $(document).on('keydown.enter-dropdown', function(e){
        //         $dropdown.addClass('drop_down_start');
        //         if(e.keyCode === 9){ //40 - Down, 38 - Up
        //             console.log('Enter Dropdown');
        //             $(document).off('keydown.enter-dropdown');

        //             var $currentItem = $dropdown.find('li').first();
                    
        //             $(document).on('keydown.in-dropdown', function(event){
        //                 if(event.shiftKey && event.keyCode == 9){
        //                     console.log('tab shift!')
        //                 }
        //                 if(event.keyCode === 40 || event.keyCode === 9){
        //                     console.log('Down')
        //                     var $nextItem = $currentItem.next('li');
        //                     var $nextLink = $currentItem.next('li').find('a');
                            
        //                     console.log($nextLink)

        //                     if($nextItem.length > 0){
        //                         $nextLink.trigger('focus');
        //                         $currentItem = $nextItem;
        //                         event.preventDefault()
        //                     }
                            
        //                 }
        //                 if(event.keyCode === 38 || (event.shiftKey && event.keyCode == 9)){
        //                     console.log('Up');
        //                     var $prevItem = $currentItem.prev('li');
        //                     var $prevLink = $currentItem.prev('li').find('a');

        //                     console.log($prevLink)

        //                     if($prevItem.length > 0){
        //                         $prevLink.trigger('focus');
        //                         $currentItem = $prevItem;
        //                     }
        //                     event.preventDefault()
        //                 }
                       
        //             })

        //             //e.preventDefault()
        //         }
        //    }); 
        })
    })
})