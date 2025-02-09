$(document).ready(function () {
    let currentStep = 1;
    const totalSteps = 4;

    // Template selection
    $('.template-card').click(function () {
        $('.template-card').removeClass('selected');
        $(this).addClass('selected');
    });

    // Navigation between sections
    $('.next-section').click(function () {
        if (currentStep < totalSteps) {
            $('.form-section').removeClass('active');
            $(`.form-section[data-step="${currentStep + 1}"]`).addClass('active');
            currentStep++;
            updateNavigation();
        }
    });

    $('.prev-section').click(function () {
        if (currentStep > 1) {
            $('.form-section').removeClass('active');
            $(`.form-section[data-step="${currentStep - 1}"]`).addClass('active');
            currentStep--;
            updateNavigation();
        }
    });

    function updateNavigation() {
        $('.progress-bar').css('width', `${(currentStep / totalSteps) * 100}%`);
        $('.step-indicator').text(`Step ${currentStep} of ${totalSteps}`);
        $('.prev-section').prop('disabled', currentStep === 1);
        $('.next-section').prop('disabled', currentStep === totalSteps);
    }


    // LIVE CHANGE RESUME TEMPLATE
    $(".template-card").click(function () {
        let selectedTemplate = $(this).data("template");
        // let userId = $("#user_id").val(); // Get user ID from hidden input

        $.ajax({
            url: "../resume.php",
            type: "POST",
            data: { template: selectedTemplate },
            success: function (response) {
                $("#resumePreview").fadeOut(200, function () {
                    $(this).html(response).fadeIn(200);
                });
            },
            error: function () {
                console.error("Error loading template.");
            },
        });
    });

    // LIVE PREVIEW SYSTEM
    $(document).on("input", "input, textarea", function () {
        let fieldName = $(this).attr("name");
        let value = $(this).val();
        $('[data-preview="' + fieldName + '"]').text(value || fieldName);
    });

    // GENERATE RESUME AJAX REQUEST
    $('#generateResume').click(function () {
        let formData = {
            personalInfo: {
                fullName: $('input[name="fullName"]').val(),
                email: $('input[name="email"]').val(),
                phone: $('input[name="phone"]').val(),
                location: $('input[name="location"]').val(),
                summary: $('textarea[name="summary"]').val()
            },
            education: [],
            experience: [],
            skills: []
        };

        // Collect education entries
        $('.education-entry').each(function () {
            formData.education.push({
                degree: $('input[name="degree"]').val(),
                institution: $('input[name="institution"]').val(),
                startDate: $('input[name="eduStartDate"]').val(),
                endDate: $('input[name="eduEndDate"]').val()
            });
        });

        // Collect experience entries
        $('.experience-entry').each(function () {
            formData.experience.push({
                jobTitle: $('input[name="jobTitle"]').val(),
                company: $('input[name="company"]').val(),
                startDate: $('input[name="expStartDate"]').val(),
                endDate: $('input[name="expEndDate"]').val(),
                responsibilities: $('textarea[name="responsibilities"]').val()
            });
        });
        
        // Collect skills entries
        $('.skills-entry').each(function () {
            formData.skills.push({
                skills: $('input[name="skills"]').val(),
                categories: $('input[name="categories"]').val()
            });
        });

        console.log("Sending Data:", JSON.stringify(formData));

        // Show loading state
        $('#generateResume').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Generating...');

        $.ajax({
            url: './controller/generate.php',
            method: 'POST',
            data: JSON.stringify(formData), // Send as regular form data
            success: function (response) {
                console.log("AJAX Response:", response);

                if (response.success === true) {
                    $('#successModal').modal('show');
                    // $('#resumePreview').html(response.html);
                } else {
                    console.log('Error:', response.message);
                    $(".error-modal-body").html(response.message);
                    $("#errorModal").modal('show');
                }
            },
            error: function (xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText);
                console.log("Status:", status);
                console.log("Error:", error);
            },
            complete: function () {
                $('#generateResume').prop('disabled', false).html('<i class="fas fa-magic me-2"></i>Generate Resume');
            }
        });
    });

    // CLONE MULTIPLE ENTRIES FUNCTION
    function cloneEntry(sectionClass, containerId, previewClass, previewContainerId, fields) {
        let count = $("." + sectionClass).length + 1;

        const newEntry = $("." + sectionClass).last().clone(true, true);
        newEntry.find("input, textarea").val("");
        newEntry.find("input, textarea").each(function () {
            let name = $(this).attr("name");
            if (name) {
                $(this).attr("name", name + count);
            }
        });

        $("#" + containerId).append(newEntry);

        const newPreview = $("." + previewClass).last().clone(true, true);
        fields.forEach(field => {
            newPreview.find(`[data-preview='${field}']`).attr("data-preview", field + count).text("Not provided");
        });

        $("#" + previewContainerId).append(newPreview);
    }

    // ADDITIONAL ENTRIES HANDLERS
    $("#addSkills").click(function () {
        cloneEntry("skills-entry", "skillsContainer", "skills-preview", "skillsPreviewContainer", ["skills", "categories"]);
    });

    $("#addEducation").click(function () {
        cloneEntry("education-entry", "educationContainer", "education-preview", "educationPreviewContainer", ["degree", "institution", "eduStartDate", "eduEndDate"]);
    });

    $("#addExperience").click(function () {
        cloneEntry("experience-entry", "experienceContainer", "experience-preview", "experiencePreviewContainer", ["jobTitle", "company", "responsibilities", "expStartDate", "expEndDate"]);
    });
});
