{if $hiddenEmail}
  {literal}
    <script type="text/javascript">
    CRM.$(function($) {
      var hiddenemails = {/literal}{$hiddenEmail}{literal};
      $.each( hiddenemails, function( i, val ) {
         $("#Email_Block_" + val).hide();
      });
    });  
    </script>
  {/literal}
{/if}

{if $emailsToHide}
  {literal}
    <script type="text/javascript">
    CRM.$(function($) {
      var hiddenemails = {/literal}{$emailsToHide}{literal};
      $.each( hiddenemails, function( i, val ) {
        $('input[value="'+ val +'"]').parent('td').parent('tr').hide();
      });
    });  
    </script>
  {/literal}
{/if}