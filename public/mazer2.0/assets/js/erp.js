document.addEventListener("DOMContentLoaded", function () {

    $('.select2').select2({ theme: "bootstrap4" });
    $('.datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        icons: {
            rightIcon: '<i class= "fa fa-calendar-alt" ></i> '
        }
    });

    if ($('.alert-info').length > 0) {
        // Hide the success message after 5 seconds
        setTimeout(function () {
            $('.alert-info').fadeOut('slow');
        }, 5000); // 5000 milliseconds = 5 seconds
    }

    $(document).on('click', '.delete_row', function (event) {
        event.preventDefault();
        var hrefValue = $(this).attr('href');
        console.log(hrefValue)
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#435ebe",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(hrefValue)
                window.location.href = hrefValue;
            }
        });


    });

});
