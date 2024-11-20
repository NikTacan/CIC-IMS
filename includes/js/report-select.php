<script>
    $(document).ready(function() {
        $('#report_type').change(function() {
            var reportType = $(this).val();
            if (reportType === 'inventory') {
                $('#inventory_form').show();
                $('#assignment_form').hide();
                $('#category_form').hide();
                $('#location_form').hide();
            } else if (reportType === 'assignment') {
                $('#assignment_form').show();
                $('#inventory_form').hide();
                $('#category_form').hide();
                $('#location_form').hide();
            } else if (reportType === 'category') {
                $('#category_form').show();
                $('#inventory_form').hide();
                $('#assignment_form').hide();
                $('#location_form').hide();
            } else if (reportType === 'location') {
                $('#location_form').show();
                $('#inventory_form').hide();
                $('#assignment_form').hide();
                $('#category_form').hide();
            }
        });
    });
</script>

<!-- Inventory report form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pickInventoryCheckbox = document.querySelector('.pick-inventory-checkbox');
        const allInventoryCheckbox = document.querySelector('.all-inventory-checkbox');

        // Inventory form elements
        const pickDatesInventory = document.querySelector('#pick-dates-inventory');
        const allDatesInventory = document.querySelector('#all-dates-inventory');

        pickInventoryCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesInventory.style.display = 'flex';
                allDatesInventory.style.display = 'none';
                allInventoryCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                pickDatesInventory.style.display = 'none';
            }
        });


        allInventoryCheckbox.addEventListener('change', function() {
            if (this.checked) {
                allDatesInventory.style.display = 'flex';
                pickDatesInventory.style.display = 'none';
                pickInventoryCheckbox.checked = false; // Uncheck the Pick Dates checkbox
            } else {
                allDatesInventory.style.display = 'none';
            }
        });
    });
</script> <!-- Inventory report form -->

<!-- Inventory assignment report form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Assignment check box
        const pickAssignmentCheckbox = document.querySelector('.pick-assignment-checkbox');
        const allAssignmentCheckbox = document.querySelector('.all-assignment-checkbox');

        // Inventory Assignment form elements
        const pickDatesAssignment = document.querySelector('#pick-dates-assignment');
        const allDatesAssignment = document.querySelector('#all-dates-assignment');


        pickAssignmentCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesAssignment.style.display = 'flex';
                allDatesAssignment.style.display = 'none';
                allAssignmentCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                pickDatesAssignment.style.display = 'none';
            }
        });

        allAssignmentCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesAssignment.style.display = 'none';
                allDatesAssignment.style.display = 'flex';
                pickAssignmentCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                allDatesAssignment.style.display = 'none';
            }
        });

    });
</script> <!-- Inventory assignment report form -->

<!-- Category report form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Category check box
        const pickCategoryCheckbox = document.querySelector('.pick-category-checkbox');
        const allCategoryCheckbox = document.querySelector('.all-category-checkbox');

        // Inventory Category form elements
        const pickDatesCategory = document.querySelector('#pick-dates-category');
        const allDatesCategory = document.querySelector('#all-dates-category');


        pickCategoryCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesCategory.style.display = 'flex';
                allDatesCategory.style.display = 'none';
                allCategoryCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                pickDatesCategory.style.display = 'none';
            }
        });

        allCategoryCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesCategory.style.display = 'none';
                allDatesCategory.style.display = 'flex';
                pickCategoryCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                allDatesCategory.style.display = 'none';
            }
        });

    });
</script> <!-- Inventory Category report form -->

<!-- Location report form -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Location check box
        const pickLocationCheckbox = document.querySelector('.pick-location-checkbox');
        const allLocationCheckbox = document.querySelector('.all-location-checkbox');

        // Inventory Location form elements
        const pickDatesLocation = document.querySelector('#pick-dates-location');
        const allDatesLocation = document.querySelector('#all-dates-location');


        pickLocationCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesLocation.style.display = 'flex';
                allDatesLocation.style.display = 'none';
                allLocationCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                pickDatesLocation.style.display = 'none';
            }
        });

        allLocationCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pickDatesLocation.style.display = 'none';
                allDatesLocation.style.display = 'flex';
                pickLocationCheckbox.checked = false; // Uncheck the All Dates checkbox
            } else {
                allDatesLocation.style.display = 'none';
            }
        });

    });
</script> <!-- Inventory Location report form -->