$(document).ready(function() {
  $('.delete_data').click(function() {
    var id = $(this).attr('id');
    if (comrfimer('Voulez-vous vraiment supprimer ce patient ?')) {
      window.location =
        '<?php echo base_url("admin/home"); ?>delete_data/' + id;
    } else {
      return false;
    }
  });
});
