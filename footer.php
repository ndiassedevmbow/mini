<footer class="footer mt-auto py-3 bg-light">
  <div class="container">
    <span class="text-muted">Commander devient un luxe ici</span>
  </div>
</footer>


  <script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js"integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  </script>


  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css"/>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

  <script type="text/javascript">
      $(document).ready( function () {
      $("#myTable").dataTable({
      "oLanguage": {
      "sLengthMenu": "Afficher MENU Enregistrements",
      "sSearch": "Rechercher:",
      "sInfo":"Total de TOTAL enregistrements (_END_ / _TOTAL_)",
      "oPaginate": {
      "sNext": "Suivant",
      "sPrevious":"Précédent"}}})});
  </script>

</body>
</html>