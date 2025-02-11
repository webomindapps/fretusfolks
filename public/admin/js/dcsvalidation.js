$(document).ready(function () {
    function validateForm() {
        var isValid = true;
        $(".error").remove();

        // Validate Interview Date
        var interviewDate = $('#interview_date').val();
        var currentDate = new Date().toISOString().split('T')[0];

        if (!interviewDate) {
            isValid = false;
            $('#interview_date').after(
                "<span class='error' style='color:red; font-size: 13px;'>Please select an interview date.</span>"
            );
        // } else if (new Date(interviewDate) < new Date(currentDate)) {
        //     isValid = false;
        //     $('#interview_date').after(
        //         "<span class='error' style='color:red; font-size: 13px;'>Interview date cannot be in the past.</span>"
        //     );
        }

        // Validate Joining Date
        var joiningDate = $('#joining_date').val();

        if (!joiningDate) {
            isValid = false;
            $('#joining_date').after(
                "<span class='error' style='color:red; font-size: 13px;'>Please select a joining date.</span>"
            );
        // } else if (new Date(joiningDate) < new Date(currentDate)) {
        //     isValid = false;
        //     $('#joining_date').after(
        //         "<span class='error' style='color:red; font-size: 13px;'>Joining date cannot be in the past.</span>"
        //     );
        }

        // Validate Aadhar Number
        var aadharPattern = /^\d{12}$/;
        $(' #father_aadhar_no, #mother_aadhar_no, #aadhar_no').each(function () {
            var aadharNumber = $(this).val();
            if (!aadharNumber) {
                isValid = false;
                $(this).after(
                    "<span class='error' style='color:red; font-size: 13px;'>Please enter the Aadhar number.</span>"
                );
            } else if (!aadharPattern.test(aadharNumber)) {
                isValid = false;
                $(this).after(
                    "<span class='error' style='color:red; font-size: 13px;'>Aadhar number must be a 12-digit numeric value.</span>"
                );
            }
        });

        // Validate Document Type
        // var selectedValue = $('#document_type').val();
        // if (!selectedValue) {
        //     isValid = false;
        //     $('#document_type').closest('div').after(
        //         "<span class='error' style='color:red; font-size: 13px; display: block; margin-top: 5px;'>Please select a document type.</span>"
        //     );

        // }

        // Validate File Upload
        var file = $('#pan_path')[0].files[0];
        if (file) {
            var allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];
            var fileType = file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(fileType)) {
                isValid = false;
                $('#pan_path').after(
                    "<span class='error' style='color:red; font-size: 13px;'>Invalid file type. Only PDF, JPG, PNG, DOC, DOCX files are allowed.</span>"
                );
            }

            if (file.size > 2 * 1024 * 1024) {
                isValid = false;
                $('#pan_path').after(
                    "<span class='error' style='color:red; font-size: 13px;'>File size must not exceed 2MB.</span>"
                );
            }
        }

        return isValid;
    }




    // $('#interview_date, #joining_date').on('blur input', function () {
    //     $(this).next('.error').remove();
    //     validateForm();
    // });

    // $(' #father_aadhar_no, #mother_aadhar_no, #aadhar_no').on('blur input', function () {
    //     $(this).next('.error').remove();
    //     validateForm();
    // });

    // $('#document_type').on('change', function () {
    //     $(this).next('.error').remove();
    //     validateForm();
    // });

    $('#pan_path').on('change', function () {
        $(this).next('.error').remove();
        validateForm();
    });
    $('#pendingDetailsForm').on("submit", function (e) {
        if (!validateForm()) {
            e.preventDefault();
        }
        else {
            $('#pendingDetailsForm').submit();

        }
    });
});
