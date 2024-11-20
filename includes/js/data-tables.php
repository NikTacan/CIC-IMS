
<!-- data tables 1 -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable();
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- data tables 2 (to avoid conflict with table 1)-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#table-2').DataTable();
    });

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- add table # if neccessary -->