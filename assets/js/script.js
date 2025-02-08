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



    $(document).ready(function () {
        $("input, textarea").on("input", function () {
            let fieldId = $(this).attr("id");
            let previewId = "#preview" + fieldId.charAt(0).toUpperCase() + fieldId.slice(1);
            $(previewId).text($(this).val() || "Not provided");

            // Send data to the server via AJAX
            $.ajax({
                url: "update_preview.php",
                type: "POST",
                data: { [fieldId]: $(this).val() },
                success: function (response) {
                    console.log("Preview updated:", response);
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
    });




    
    // Add education entry
    $('#addEducation').click(function () {
        const educationEntry = $('.education-entry').first().clone();
        educationEntry.find('input').val('');
        $('#educationContainer').append(educationEntry);
    });

    // Add experience entry
    $('#addExperience').click(function () {
        const experienceEntry = $('.experience-entry').first().clone();
        experienceEntry.find('input, textarea').val('');
        $('#experienceContainer').append(experienceEntry);
    });

    // Add skills entry
    $('#addSkills').click(function () {
        const skillsEntry = $('.skills-entry').first().clone();
        skillsEntry.find('input, textarea').val('');
        $('#skillsContainer').append(skillsEntry);
    });

    // Generate Resume
    $('#generateResume').click(function () {
        $generateResumeValue = $('#generateResume').val();

        // const selectedTemplate = $('.template-card.selected').data('template');
        // if (!selectedTemplate) {
        //     alert('Please select a template first');
        //     return;
        // }

        const formData = {
            // template: selectedTemplate,
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
                degree: $(this).find('input[name="degree[]"]').val(),
                institution: $(this).find('input[name="institution[]"]').val(),
                startDate: $(this).find('input[name="eduStartDate[]"]').val(),
                endDate: $(this).find('input[name="eduEndDate[]"]').val()
            });
        });

        // Collect experience entries
        $('.experience-entry').each(function () {
            formData.experience.push({
                jobTitle: $(this).find('input[name="jobTitle[]"]').val(),
                company: $(this).find('input[name="company[]"]').val(),
                startDate: $(this).find('input[name="expStartDate[]"]').val(),
                endDate: $(this).find('input[name="expEndDate[]"]').val(),
                responsibilities: $(this).find('textarea[name="responsibilities[]"]').val()
            });
        });

        // Collect skills entries
        $('.skills-entry').each(function () {
            formData.skills.push({
                skills: $(this).find('input[name="skills[]"]').val(),
                categories: $(this).find('input[name="categories[]"]').val()
            });
        });


        // Show loading state
        $('#generateResume').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Generating...');

        $.ajax({
            url: './controller/generate.php',
            method: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify(formData),
            success: function (response) {
                console.log("AJAX Response:", response); // Inspect the response here

                if (response.success === true) {
                    console.log('Success response received');
                    $('#successModal').modal('show');
                    $('#resumePreview').html(response.html);

                } else {
                    console.log('Error response:', response.message);
                    $(".error-modal-body").html(response.message);
                    $("#errorModal").modal('show');
                }
            },
            error: function (xhr, status, error) {
                // console.log("AJAX Error: ", error);
                console.log("AJAX Error: ", xhr.responseText); // Log the full response for debugging
                console.log("Status: ", status);
                console.log("Error: ", error);
            },
            complete: function () {
                $('#generateResume').prop('disabled', false).html('<i class="fas fa-magic me-2"></i>Generate Resume');
            }
        });
    });
});
