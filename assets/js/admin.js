jQuery(document).ready(function($) {
    // Add tooltip text to all copyable values
    $('.swi-value[data-clipboard]').attr('data-tooltip', serverWebsiteInfo.copyToClipboard);

    // Copy to clipboard functionality
    $('.swi-value[data-clipboard]').on('click', function() {
        var $this = $(this);
        var text = $this.text().trim();
        
        // Create temporary textarea
        var $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val(text).select();
        
        try {
            // Copy text
            document.execCommand('copy');
            
            // Show success state
            $this.addClass('copied');
            var originalTooltip = $this.attr('data-tooltip');
            $this.attr('data-tooltip', serverWebsiteInfo.copied);
            
            // Reset after 2 seconds
            setTimeout(function() {
                $this.removeClass('copied');
                $this.attr('data-tooltip', originalTooltip);
            }, 2000);
        } catch (err) {
            console.error('Failed to copy text:', err);
        }
        
        // Remove temporary textarea
        $temp.remove();
    });

    // Add smooth scroll to premium section
    $('.sip-upgrade-button').click(function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $('.sip-premium-card').offset().top - 100
        }, 500);
    });

    // Add refresh functionality (for premium version)
    if (sipAdmin.isPremium) {
        setInterval(function() {
            $.ajax({
                url: sipAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'sip_refresh_data',
                    nonce: sipAdmin.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Update the values
                        Object.keys(response.data).forEach(function(key) {
                            $('.sip-info-item[data-key="' + key + '"] span').text(response.data[key]);
                        });
                    }
                }
            });
        }, 30000); // Refresh every 30 seconds
    }
});
