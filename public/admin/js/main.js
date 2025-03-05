// document.addEventListener("DOMContentLoaded", function () {
//     let btn = document.querySelector("#btn");
//     let sidebar = document.querySelector(".sidebar");
//     let dropdownLinks = document.querySelectorAll(".dropdown");

//     btn.onclick = function () {
//         sidebar.classList.toggle("active");
//     }

//     dropdownLinks.forEach(link => {
//         link.addEventListener("click", function (e) {
//             let dropdownMenu = this.querySelector(".dropdown_menu");
//             $(dropdownMenu).toggle('open');
//             // dropdownMenu.classList.toggle("open");
//         });
//     });

// });
document.addEventListener("DOMContentLoaded", function () {
    let btn = document.querySelector("#btn");
    let sidebar = document.querySelector(".sidebar");
    let dropdownLinks = document.querySelectorAll(".dropdown");

    // Toggle sidebar when button is clicked
    // btn.onclick = function () {
    //     sidebar.classList.toggle("active");
    // }

    // Automatically collapse sidebar on smaller screens
    function handleSidebarResize() {
        if (window.innerWidth <= 600 && window.innerWidth >= 320) {
            sidebar.classList.remove("active"); // Collapse sidebar
        } else {
            sidebar.classList.add("active"); // Expand sidebar
        }
    }

    // Check on page load
    handleSidebarResize();

    // Check on window resize
    window.addEventListener("resize", handleSidebarResize);

    // Dropdown toggle functionality
    dropdownLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            let dropdownMenu = this.querySelector(".dropdown_menu");
            $(dropdownMenu).toggle(); // jQuery toggle
        });
    });
});

$(document).ready(function () {
    if ($('#session-success').hasClass('session-success')) {
        setTimeout(() => {
            $('#session-success').hide()
        }, 3000);
    }
    $(".profile-icon").click(function () {
        $(".profile-drop").toggleClass('d-block');
    });
});


$('.slug').on('change', function () {
    var val = $(this).val();
    var slug = val.replace(/\s/g, "-");
    $('#slug').val(slug.toLowerCase());
});


$(document).on('keypress', '.price', function (evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57))
        return false;

    return true;
})


$('.image-file').on('change', function (e) {
    var id = $(this).attr('id');
    if (this.files && this.files.length > 0) {
        var src = URL.createObjectURL(e.target.files[0]);
    } else {
        src = '';
    }
    $('#preview-image-' + id + '').attr('src', src);
});

$('.multiple-images').on('change', function (e) {
    var preview_image = '';
    for (let i = 0; i < e.target.files.length; i++) {
        const image = e.target.files[i];
        var src = URL.createObjectURL(image);
        preview_image += `<img id="preview-image-${i}" src="${src}" class="removeImg" height="100px" width="100px" style="margin-left:10px;margin-right:10px;" />`;
    }
    $('#image-section').html("");
    $('#image-section').append(preview_image);

});




//form submit functionality 
$(document).on('submit', '.formSubmit', function (e) {
    $('.submitBtn').attr('disabled', true)
    $(this).submit();
})